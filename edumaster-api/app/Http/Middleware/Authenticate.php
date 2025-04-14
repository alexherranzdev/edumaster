<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class Authenticate
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  Closure(Request): (Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if (!Auth::guard('sanctum')->check()) {
			return response()->json(['message' => 'Unauthorized'], 401);
		}

		auth()->setUser(auth()->guard('sanctum')->user());

		return $next($request);
	}
}
