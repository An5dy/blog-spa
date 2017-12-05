<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\MailService;

class CheckVerificationEmail
{
    protected $mailService;

    /**
     * 注入MailService
     *
     * CheckVerificationEmail constructor.
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
        $this->mailService->checkEmail();

        return $next($request);
    }
}
