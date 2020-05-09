<?php

namespace App\Services;

class RateLimit200Request extends RateLimitRequest
{
    public function getNumberRequestMax(): int
    {
        return 200;
    }
}
