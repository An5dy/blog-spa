<?php

namespace App\Services;

use App\Criteria\LimitCriteria;
use DB;
use Illuminate\Http\Request;
use App\Events\UpdateArticle;
use App\Repositories\TagRepository;
use App\Exceptions\ApiErrorException;
use App\Repositories\ArticleRepository;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleService
{
    protected $article;

    protected $tagRepository;

    /**
     * 插入数据
     *
     * @var
     */
    protected $attributes;

    /**
     * 查询字段
     *
     * @var array
     */
    protected $columns = [
        'id',
        'user_id',
        'category_id',
        'title',
        'description',
        'checked_num',
        'created_at'
    ];

    /**
     * 注入ArticleRepository
     *
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository, TagRepository $tagRepository)
    {
        $this->article = $articleRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * 获取文章列表
     *
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        // 列表排列顺序
        $orderBy = $request->order_by == 'time' ? 'created_at' : 'checked_num';
        $articles = $this->article
                         ->with([
                             'author' => function($query) {
                                return $query->select('id', 'name');
                             },
                             'category' => function($query) {
                                return $query->select('id', 'title');
                             },
                             'tags' => function($query) {
                                return $query->select('article_id', 'title');
                             }
                         ])
                         ->scopeQuery(function ($query) use ($request) {
                             return $query->title($request->title)
                                          ->author($request->user_id)
                                          ->category($request->category_id);
                         })
                         ->orderBy($orderBy, 'desc')
                         ->paginate(null, $this->columns);
        $this->handleArticle($articles->items());

        return new ArticleCollection($articles);
    }

    /**
     * 保存文章
     *
     * @param Request $request
     * @return array
     * @throws ApiErrorException
     */
    public function store(Request $request, $id = 0)
    {
        $this->attributes = [
            'title' => e($request->title),
            'description' => $request->description,
            'user_id' => user('api')->id,
            'category_id' => $request->category
        ];
        DB::beginTransaction();
        try {
            // 保存文章
            if (empty($id)) {
                $article = $this->article->create($this->attributes);
            } else {
                $article = $this->article->find($id);
                if (! user('api')->can('update', $article)) {
                    return api_error_info('20000', '不能修改当前文章');
                }
                $article->update($this->attributes);
            }
            // 保存文章标签
            $tags = collect($request->tags)->map(function ($tag) {
                $tagObj = $this->tagRepository->firstOrCreate(['title' => $tag]);
                return $tagObj->id;
            })->toArray();
            $article->tags()->sync($tags);
            DB::commit();

            return api_success_info('10000', '发布成功');
        } catch (\Exception $exception) {
            DB::rollback();

            throw new ApiErrorException('发布失败', '20000');
        }
    }

    /**
     * 文章详情
     *
     * @param $id
     * @return ArticleResource
     * @throws ApiErrorException
     */
    public function show($id)
    {
        try {
            $article = $this->article
                ->with([
                    'author' => function($query) {
                        return $query->select('id', 'name');
                    },
                    'category' => function($query) {
                        return $query->select('id', 'title');
                    },
                    'tags' => function($query) {
                        return $query->select('article_id', 'title');
                    }
                ])
                ->find($id, $this->columns);
            // 增加阅读数
            event(new UpdateArticle($article));

            return new ArticleResource($article);
        } catch (\Exception $exception) {

            throw new ApiErrorException('当前文章不存在', '20000');
        }
    }

    /**
     * 获取热门列表
     *
     * @return mixed
     */
    public function getHotList()
    {
        $this->article->pushCriteria(new LimitCriteria(config('global.article.hot_limit')));
        $articles = $this->article
                         ->orderBy('checked_num', 'desc')
                         ->get(['id', 'title']);

        return $articles;
    }

    /**
     * 获取最新列表
     *
     * @return mixed
     */
    public function getNewList()
    {
        $this->article->pushCriteria(new LimitCriteria(config('global.article.new_limit')));
        $articles = $this->article
                         ->orderBy('created_at', 'desc')
                         ->get(['id', 'title']);

        return $articles;
    }

    /**
     * 获取侧边栏数据
     *
     * @return array
     * @throws ApiErrorException
     */
    public function getSidebarData()
    {
        try {
            $data = collect()->put('hot', $this->getHotList())
                         ->put('new', $this->getNewList())
                         ->all();

            return api_success_info('10000', 'success', $data);
        } catch (\Exception $exception) {

            throw new ApiErrorException('出错了', '20000');
        }
    }

    /**
     * 删除文章
     *
     * @param $id
     * @return array
     * @throws ApiErrorException
     */
    public function delete($id)
    {
        try {
            $article = $this->article->find($id);
            dd(user('api')->can('delete', $article));
            if (user('api')->can('delete', $article)) {
                $article->delete($id);
                return api_success_info('10000', '删除成功');
            } else {
                return api_error_info('20000', '不能删除当前文章');
            }
        }catch (\Exception $exception) {
            throw new ApiErrorException('删除失败', '20000');
        }
    }

    /**
     * 文章详情
     *
     * @param $id
     * @return ArticleResource
     * @throws ApiErrorException
     */
    public function edit($id)
    {
        try {
            $article = $this->article
                            ->with([
                                'tags' => function($query) {
                                    return $query->select('article_id', 'title');
                                }
                            ])
                            ->find($id, $this->columns);

            return new ArticleResource($article);
        } catch (\Exception $exception) {
            throw new ApiErrorException('获取文章失败', '20000');
        }
    }

    /**
     * 设置文章列表详情显示字数及高亮提示
     *
     * @param $articles
     */
    protected function handleArticle($articles)
    {
        if (! $articles instanceof Collection) {
            $articles = collect($articles);
        }
        $title = request()->title;
        $articles->each(function ($article) use ($title){
            // 列表展示字数
            $article->description = str_limit($article->description, config('global.article.limit'));
            // 标记搜索内容
            if (! empty($title)) {
                $arr = explode($title, $article->title);
                $article->title = implode('<span style="color:#1abc9c">' . $title . '</span>', $arr);
            }
        });
    }
}