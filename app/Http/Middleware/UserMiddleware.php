<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Common\StatusCode;
use App\Traits\ApiResponse;

use Closure;

class UserMiddleware
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
        $user = Auth::user();
        if ($user->role == 2) {
            return $next($request);
        }
        return $this->errorResponse('UnAuthorised', StatusCode::UNAUTHORIZED);
    }
}
