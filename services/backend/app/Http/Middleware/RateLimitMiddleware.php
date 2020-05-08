<?php

namespace App\Http\Middleware;

use App\Exceptions\RateLimitedException;
use App\Services\RateLimitRequest;
use App\Services\RateLimitRequestInterFace;
use Illuminate\Http\Request;
use Closure;

class RateLimitMiddleware
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
            if ($rateLimitRequest = $this->getServiceRateLimitRequest($request)->checkRateLimited()) {
                $rateLimitRequest->setRateLimitRequest();
                return $next($request);
            }
        } catch (RateLimitedException $e) {
            return response()->json(['message' => 'Enhance Your Calm'], 420);
        }
    }

    public function getServiceRateLimitRequest(Request $request): RateLimitRequestInterFace
    {
        return new RateLimitRequest($request);
    }
}
