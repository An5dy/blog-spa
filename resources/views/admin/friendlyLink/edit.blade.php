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
                            <li><a href="/admin/friendly_links">链接</a></li>
                            <li class="active">编辑</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" action="/admin/friendly_links/{{ $friendlyLink->id }}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">链接名称</label>
                                <div class="col-md-6">
                                    <input id="description" class="form-control" name="description" value="{{ $friendlyLink->description }}" required autofocus>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('path') ? ' has-error' : '' }}">
                                <label for="path" class="col-md-4 control-label">链接地址</label>
                                <div class="col-md-6">
                                    <input id="path" class="form-control" name="path" value="{{ $friendlyLink->path }}" required autofocus>
                                    @if ($errors->has('path'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('path') }}</strong>
                                         </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        确认
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