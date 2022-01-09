<?php

namespace App\Helper;

use App\Interfaces\Provider as ProviderInterface;
use Core\App;

abstract class Provider implements ProviderInterface
{
    protected App $app;

    public function __construct()
    {
        $this->app = App::instance();
    }

    public static function boot()
    {
        $instance = new static();
        $instance->run();
        return $instance;
    }
}