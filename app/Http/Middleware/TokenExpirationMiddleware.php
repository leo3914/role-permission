<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class TokenExpirationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->bearerToken();
        $accessToken = PersonalAccessToken::findToken($token);

        if($accessToken){
            $expirationTime = Carbon::parse($accessToken->created_at)->addSeconds(15);
        }

        if ($expirationTime->isPast()) {
            return response()->json(['message' => 'Token expired'], 401);
        }
        
        return $next($request);
    }
}
