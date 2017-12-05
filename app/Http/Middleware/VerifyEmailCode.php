<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\MailService;

class VerifyEmailCode
{
    protected $mailService;

    /**
     * VerifyEmailCode constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
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
        $verificationCode = $this->mailService->verify($request);
        $request->request->add(['verificationCode' => $verificationCode]);

        return $next($request);
    }
}
