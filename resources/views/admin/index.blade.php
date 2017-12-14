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
                            <li class="active">管理员</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" action="/admin/admin/update" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">姓名</label>
                                <div class="col-md-6">
                                    <input id="name" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('olPassword') ? ' has-error' : '' }}">
                                <label for="old_password" class="col-md-4 control-label">原密码</label>
                                <div class="col-md-6">
                                    <input id="path" class="form-control" type="password" name="oldPassword" required autofocus>
                                    @if ($errors->has('olPassword'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('olPassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                                <label for="newPassword" class="col-md-4 control-label">新密码</label>
                                <div class="col-md-6">
                                    <input id="path" class="form-control" type="password" name="newPassword">
                                    @if ($errors->has('newPassword'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        修改
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection