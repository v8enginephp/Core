<?php

namespace App\Provider;

use App\Helper\Provider;
use Whoops\{Run, Handler\PrettyPageHandler, Handler\JsonResponseHandler};

class Whoops extends Provider
{
    public function run(): void
    {
        if (env('DEBUG', false)) {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }
}