<?php

namespace App\Provider;

use App\Helper\Provider;
use Predis\Client;

class Redis extends Provider
{
    public function run(): void
    {
        if (env("REDIS", 0)) {
            $redis = new Client([
                'host' => env("REDIS_HOST", "127.0.0.1"),
                'port' => env("REDIS_PORT", 6379),
            ]);

            if (env("REDIS_AUTH", 0))
                $redis->auth(env("REDIS_PASSWORD"));

            container('redis', $redis);
        }
    }
}