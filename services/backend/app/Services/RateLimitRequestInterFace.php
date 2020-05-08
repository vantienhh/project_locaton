<?php

namespace App\Services;

interface RateLimitRequestInterFace
{
    public function checkRateLimited(): RateLimitRequestInterFace;

    public function setRateLimitRequest();

    public function getKeyRedis(): string;
}
