<?php

namespace App\Http\Middleware;

use App\Exceptions\RateLimitedException;
use App\Services\RateLimit200Request;
use App\Services\RateLimitRequestInterFace;
use Illuminate\Http\Request;
use Closure;

class RateLimit200RequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request
     * @param \Closure    $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            $this->getServiceRateLimitRequest($request)->checkRateLimited();
            return $next($request);
        } catch (RateLimitedException $e) {
            return response()->json(['message' => 'Enhance Your Calm'], 420);
        }
    }

    public function getServiceRateLimitRequest(Request $request): RateLimitRequestInterFace
    {
        return new RateLimit200Request($request);
    }
}
