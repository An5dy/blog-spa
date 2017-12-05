<?php

if ( ! function_exists('api_success_info')) {
    /**
     * api正确返回格式
     *
     * @param $code
     * @param $message
     * @return array
     */
    function api_success_info($code, $message, array $data = [])
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }
}

if ( ! function_exists('api_error_info')) {
    /**
     * 错误提示
     *
     * @param $code
     * @param $message
     * @return array
     */
    function api_error_info($code, $message)
    {
        return [
            'code' => $code,
            'message' => $message,
        ];
    }
}

if ( ! function_exists('user')) {
    /**
     * 返回当前登录的用户信息
     *
     * @param null $guard
     * @return mixed
     */
    function user($guard = null)
    {
        return empty($guard) ? app('auth')->user() : app('auth')->guard($guard)->user();
    }
}