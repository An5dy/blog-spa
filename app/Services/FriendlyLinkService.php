<?php

namespace App\Services;

use App\Http\Resources\FriendlyLinkCollection;
use Illuminate\Http\Request;
use App\Repositories\FriendlyLinkRepository;

class FriendlyLinkService
{
    protected $friendlyLinkRepository;

    protected $attributes = [];

    /**
     * FriendlyLinkService constructor.
     * @param FriendlyLinkRepository $friendlyLinkRepository
     */
    public function __construct(FriendlyLinkRepository $friendlyLinkRepository)
    {
        $this->friendlyLinkRepository = $friendlyLinkRepository;
    }

    /**
     * 获取列表
     *
     * @return mixed
     */
    public function get()
    {
        $friendlyLinks = $this->friendlyLinkRepository
                              ->paginate(null, ['id', 'path', 'description', 'created_at']);

        return $friendlyLinks;
    }

    /**
     * 获取链接列表
     *
     * @return FriendlyLinkCollection
     */
    public function all()
    {
        $friendlyLinks = $this->friendlyLinkRepository
                              ->all(['id', 'path', 'description']);

        return new FriendlyLinkCollection($friendlyLinks);
    }

    /**
     * 保存
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->attributes = [
            'path' => $request->path,
            'description' => $request->description,
        ];

        $this->friendlyLinkRepository
             ->create($this->attributes);
    }

    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $friendlyLink = $this->friendlyLinkRepository
                             ->find($id, ['id', 'description', 'path']);

        return $friendlyLink;
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return $this->friendlyLinkRepository
                    ->update(['path' => $request->path, 'description' => $request->description], $id);
    }

    /**
     * 删除
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $this->friendlyLinkRepository->delete($id);

            return api_success_info('10000', '删除成功');
        } catch (\Exception $exception) {
            throw new ApiErrorException('删除失败', '20000');
        }
    }
}