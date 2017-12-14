@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">登录</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="请输入用户名">
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input type="password" class="form-control" name="password" required placeholder="请输入密码">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住密码
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">登录</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
