<?php

namespace App\Services;

class RateLimit20Request extends RateLimitRequest
{
    public function getNumberRequestMax(): int
    {
        return 20;
    }
}
