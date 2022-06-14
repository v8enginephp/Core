<?php

namespace App\Provider;

use App\Helper\Logger;
use App\Interfaces\Provider;
use Core\App;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Log;

class Env implements Provider
{
    public function __construct()
    {
        session_start();
    }


    public function run(): void
    {
        Dotenv::createImmutable(BASEDIR)->load();
        /*
         * Set Application Mode (Develop | Production)
         */
        App::setMode();

        /*
         * Set Default Timezone
         */
        App::setTimezone();


        $this->logger();
    }

    private function logger()
    {
        Log::swap((new Logger("logger"))->initialize(BASEDIR . "/" . env("LOG_PATH", "storage/logs")));
    }
}
