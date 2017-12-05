<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ApiErrorException extends Exception
{
    protected $message;

    protected $code;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * 自定义错误
     *
     * @return array
     */
    public function handel()
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }

    /**
     * 将异常渲染到 HTTP 响应中。
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function render($request)
    {
        return response()->json($this->handel());
    }
}
