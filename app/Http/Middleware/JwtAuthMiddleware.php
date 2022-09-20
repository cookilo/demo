<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user){
                return response()->json([
                    'status' => config('api-code.status.error'),
                    'code' => 401,
                    'data' => new \stdClass(),
                    'message' => __('message.deleted_account_message')
                ], 401);
            }
        } catch (Exception $e) {
            Log::error($e);
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status' => config('api-code.status.error'),
                    'code' => 401,
                    'data' => new \stdClass()
                ], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status' => config('api-code.status.error'),
                    'code' => 401,
                    'data' => new \stdClass()
                ], 401);

            } else {
                return response()->json([
                    'status' => config('api-code.status.error'),
                    'code' => 401,
                    'data' => new \stdClass()
                ], 401);
            }
        }
        return $next($request);
    }
}

