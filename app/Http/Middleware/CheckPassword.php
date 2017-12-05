<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiErrorException;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $boolean = Hash::check($request->oldPassword, $user->getAuthPassword());
        if (! $boolean) {
            throw new ApiErrorException('原密码错误', '20000');
        }

        return $next($request);
    }
}
