<?php

namespace App\Services;

use App\Exceptions\RateLimitedException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Redis\Connections\Connection as RedisConnection;

abstract class RateLimitRequest implements RateLimitRequestInterFace
{
    const TIMEREQUEST = 60;     // Thời gian để check rate limit (tính bằng giây)

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

    /**
     * Cấu trúc dữ liệu như sau: user_id-URI: [count,start_time]. VD: 12-api/limit_200/get_provinces: [1, 1560580210]
     *      count: Số lượng request
     *      start_time: Thời gian bắt đầu
     *
     * Cách thực hiện:
     *  - Nếu key không tồn tại thì tạo 1 bản ghi vs thời gian hiện tại và count = 1
     *  - Nếu tồn tại key thì check current_time - start_time >= TIMEREQUEST
     *      - Nếu lớn hơn thì set start_time là current_time và count = 1
     *      - Nếu nhỏ hơn thì kiểm tra count >= SỐ_LƯỢNG_REQUEST
     *          - Nếu lớn hơn: Lỗi
     *          - Nhỏ hơn thì set count = count + 1
     */
    public function checkRateLimited()
    {
        $key         = $this->getKeyRedis();
        $data        = $this->redis->get($key);
        $currentTime = Carbon::now()->timestamp;

        if (is_null($data)) {
            $this->redis->set($key, $this->setValueOfRedis(1, $currentTime));
        } else {
            $data = $this->getValueOfRedis($data);

            if ($currentTime - $data[1] >= self::TIMEREQUEST) {
                $this->redis->set($key, $this->setValueOfRedis(1, $currentTime));
            } else {
                if ($data[0] >= $this->getNumberRequestMax()) {
                    throw new RateLimitedException();
                }
                $this->redis->set($key, $this->setValueOfRedis($data[0] + 1, $data[1]));
            }
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

    abstract public function getNumberRequestMax(): int;
}
