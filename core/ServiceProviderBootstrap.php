<?php
/**
 * @copyright Aliakbar Soleimani 2020
 * Class ServiceProviderBootstrap
 * Bootstrap Files
 */

namespace Core;

use App\Helper\Provider;
use Illuminate\Support\Collection;

/**
 * Class ServiceProviderBootstrap
 * @package Core
 */
final class ServiceProviderBootstrap
{
    const PROVIDERS_DIR = __DIR__ . "/../app/Provider";

    private static Collection $services;

    private function __construct()
    {
        isset(self::$services) ?: self::$services = collect([]);
    }

    private function getServiceList()
    {
        return self::$services = collect(array_merge(self::$services->toArray(), config("services", true)));
    }

    private function load($provider)
    {
        $provider = new $provider();
        /**
         * @var Provider $provider
         */
        $provider->run();
    }

    private function initialize(?array $services)
    {
        foreach ($services ?? $this->getServiceList() as $service) {
            $this->load($service);
        }
        return $this;
    }

    public static function run($services = null)
    {
        return (new self)->initialize($services);
    }
}