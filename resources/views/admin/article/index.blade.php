@extends('admin.layouts.app')

@section('content')
    <div id="wrapper">
        @include('admin.layouts.nav')
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 header-page">
                        <ol class="breadcrumb col-lg-6 col-md-6 col-sm-6">
                            <li><a href="/admin">首页</a></li>
                            <li><a href="/admin/articles">文章</a></li>
                            <li class="active">列表</li>
                        </ol>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="col-lg-8 pull-right search">
                                <form class="search-form" action="/admin/articles">
                                    <input type="text" class="form-control" name="title" placeholder="请输入要搜索的文章标题">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td class="text-center">ID</td>
                                <td class="text-center">标题</td>
                                <td class="text-center">作者</td>
                                <td class="text-center">类别</td>
                                <td class="text-center">标签</td>
                                <td class="text-center">查看次数</td>
                                <td class="text-center">发布时间</td>
                                <td class="text-center">操作</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td class="text-center">{{ $article->id }}</td>
                                    <td class="text-center">{{ $article->title }}</td>
                                    <td class="text-center">{{ $article->author->name }}</td>
                                    <td class="text-center"><span class="label label-primary">{{ $article->category->title }}</span></td>
                                    <td class="text-center">
                                        @if(! empty($article->tags))
                                            @foreach($article->tags as $tag)
                                                <span class="label label-success">{{ $tag->title }} <a class="delete-tag" data-id="{{ $tag->pivot->tag_id }}"><i class="fa fa-remove"></i></a></span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $article->checked_num }}</td>
                                    <td class="text-center">{{ $article->created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-xs btn-delete-article" data-id="{{ $article->id }}"><i class="fa fa-remove fa-fw"></i>删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $('.btn-delete-article').click(function () {
            if (confirm('确认删除文章？')) {
                var obj = $(this);
                var id = obj.attr('data-id');
                $.ajax({
                    url: '/admin/articles/delete/' + id,
                    type: 'post',
                    data: {"_token": window.Laravel.csrfToken},
                    success: function (data) {
                        if (data.code === '10000') {
                            obj.parent().parent().remove();
                        }
                    }
                })
            }
        })
        $('.delete-tag').click(function () {
            if (confirm('确认删除标签？')) {
                var obj = $(this);
                var id = obj.attr('data-id');
                $.ajax({
                    url: '/admin/tags/delete/' + id,
                    type: 'post',
                    data: {"_token": window.Laravel.csrfToken},
                    success: function (data) {
                        if (data.code === '10000') {
                            obj.parent().remove();
                        }
                    }
                })
            }
        })
    </script>
@endsection