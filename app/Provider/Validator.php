<?php

namespace App\Provider;

use Core\Translation;
use App\Helper\Presence;
use App\Helper\Provider;
use Illuminate\{Container\Container, Validation\Factory};

class Validator extends Provider
{
    public function run(): void
    {
        container("validation_attributes", []);
        $this->app->validator = new Factory(Translation::getTranslator(), new Container);
        $this->app->validator->setPresenceVerifier(new Presence());
    }
}