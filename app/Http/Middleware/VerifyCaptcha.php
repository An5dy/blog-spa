<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\GeeTestCaptcha\GeeCaptcha;

class VerifyCaptcha
{
    protected $geeCaptcha;

    /**
     * 注入GeeCaptcha
     *
     * VerifyCaptcha constructor.
     * @param GeeCaptcha $geeCaptcha
     */
    public function __construct(GeeCaptcha $geeCaptcha)
    {
        $this->geeCaptcha = $geeCaptcha;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->geeCaptcha->verifyCaptcha($request->geetest_challenge, $request->geetest_validate, $request->geetest_seccode);

        return $next($request);
    }
}
