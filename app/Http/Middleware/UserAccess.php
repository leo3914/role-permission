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
        if ($request->user()->role_id == $role) {
            return $next($request);
        }
        return response()->json([
            'message' => "U haven't permission. Please try again."
        ], 403);

        // if (!in_array($request->user()->role_id, $roles)) {
        //     return response()->json([
        //         'message' => "You don't have permission to access this resource."
        //     ], 403);
        // }
        // return $next($request);
    }
}
