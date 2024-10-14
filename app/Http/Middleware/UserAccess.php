<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ( $request->user()->role_id == $role) {
            return $next($request);
        }
        // dd( $role);
        return response()->json([
            'role_id' => $request->user()->role_id,
            'message' => "U haven't permission. Please try again."
        ], 403);
    }
}
