<?php

namespace App\Services;

interface RateLimitRequestInterFace
{
    public function checkRateLimited();

    public function getKeyRedis(): string;

    public function getNumberRequestMax(): int;
}
