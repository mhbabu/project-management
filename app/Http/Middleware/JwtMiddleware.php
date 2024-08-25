<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\JsonResponse;

class JwtMiddleware
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
        try {
            // Check if the token is present and valid
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return new JsonResponse(['status' => 'Token is Invalid'], 401);
            } elseif ($e instanceof TokenExpiredException) {
                return new JsonResponse(['status' => 'Token is Expired'], 401);
            } else {
                return new JsonResponse(['status' => 'Authorization Token not found'], 401);
            }
        }

        return $next($request);
    }
}
