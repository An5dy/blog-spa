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
                            <li><a href="/admin/users">用户</a></li>
                            <li class="active">列表</li>
                        </ol>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="col-lg-8 pull-right search">
                                <form class="search-form" action="/admin/users">
                                    <input type="search" class="form-control" name="search" placeholder="请输入要搜索的用户名">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">姓名</th>
                                <th class="text-center">头像</th>
                                <th class="text-center">邮箱</th>
                                <th class="text-center">注册时间</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center"><img src="{{ $user->avatar_thumb }}" style="border-radius: 50px;width: 20px"></td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->created_at }}</td>
                                    <td class="text-center">
                                        @if($user->status == 1)
                                            <a class="btn btn-xs btn-ban-user" data-id="{{ $user->id }}"><i class="fa fa-check">允许登录</i></a>
                                        @else
                                            <a class="btn btn-warning btn-xs btn-ban-user" data-id="{{ $user->id }}"><i class="fa fa-remove">禁止登录</i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $('.btn-ban-user').click(function () {
            var obj = $(this);
            var html = obj.children('i').html();
            if (confirm(html + '?')) {
                var id = obj.attr('data-id');
                $.ajax({
                    url: '/admin/users/toggle_ban/' + id,
                    type: 'post',
                    data: {"_token": window.Laravel.csrfToken},
                    success: function (data) {
                        if (data.data.status == 1) {
                            obj.removeClass('btn-warning');
                            obj.children('i').removeClass('fa-remove');
                            obj.children('i').addClass('fa-check');
                            obj.children('i').html('允许登录');
                        }
                        if (data.data.status == 0) {
                            obj.addClass('btn-warning');
                            obj.children('i').removeClass('fa-check');
                            obj.children('i').addClass('fa-remove');
                            obj.children('i').html('禁止登录');
                        }
                    }
                })
            }
        })
    </script>
@endsection