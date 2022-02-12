<?php

namespace App\Provider;

use App\Helper\Provider;
use Core\Module as BaseModule;


class Module extends Provider
{
    public function run(): void
    {
        BaseModule::run();
        listen("init", app());
    }
}
