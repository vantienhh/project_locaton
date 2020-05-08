<?php

namespace App\Services;

use App\Exceptions\RateLimitedException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Redis\Connections\Connection as RedisConnection;

class RateLimitRequest implements RateLimitRequestInterFace
{
    private RedisConnection $redis;
    private Request         $request;

    public function __construct(Request $request)
    {
        $this->redis   = Redis::connection();
        $this->request = $request;
    }

    public function getKeyRedis(): string
    {
        return $this->request->user() . '-' . $this->request->route()->uri;
    }

    public function checkRateLimited(): RateLimitRequest
    {
//        throw new RateLimitedException();
        return $this;
    }

    /**
     * Cấu trúc dữ liệu như sau: user_id-URI: [count, start_time]. VD: 12-api/limit_200/get_provinces: [1, 1560580210]
     *      count: Số lượng request
     *      start_time: Thời gian bắt đầu
     */
    public function setRateLimitRequest()
    {
        $key    = $this->getKeyRedis();
        $record = $this->redis->get($key);

        if (is_null($record)) {
            $this->redis->set($key, $this->setValueOfRedis(1, Carbon::now()->timestamp));
        } else {

        }
    }

    protected function setValueOfRedis(int $sort, int $startTime): string
    {
        return json_encode([$sort, $startTime]);
    }

    protected function getValueOfRedis(string $value): array
    {
        return json_decode($value);
    }
}
