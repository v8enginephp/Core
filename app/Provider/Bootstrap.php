<?php

namespace App\Provider;

use App\Exception\V8Exception;
use App\Helper\Provider;
use App\Kernel;

class Bootstrap extends Provider
{
    private array $providers;

    public function __construct()
    {
        parent::__construct();
        $this->providers = Kernel::$providers;
    }

    public function run(): void
    {
        foreach ($this->providers as $provider) {
            if (is_subclass_of($provider, Provider::class)) {
                $provider::boot();
            } else {
                throw new V8Exception("provider.not.allowed", "$provider Must Extends App\\Helper\\Provider");
            }
        }
    }
}