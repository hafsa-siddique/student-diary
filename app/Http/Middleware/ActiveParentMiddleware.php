<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveParentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }
        $parent = $user->parent;
        if (!$parent || $parent->institute_id !== $user->institute_id){
            return response()->json([
                'status' => false,
                'message' => 'Parent profile not found.',
            ], 404);
        }
        if (!$user->status || !$parent->status) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is inactive.',
            ], 403);
        }
        return $next($request);
    }
}
