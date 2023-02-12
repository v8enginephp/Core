<?php

namespace App\Provider;

use App\Interfaces\Provider;
use App\Kernel;
use Core\App;
use Illuminate\Http\Request as BaseRequest;
use Illuminate\{Container\Container,
    Routing\CallableDispatcher,
    Routing\Redirector,
    Routing\Router,
    Routing\UrlGenerator,
    Support\Facades\Route
};

class Request implements Provider
{
    private $container;
    private $request;
    private $router;
    private $url;
    private $app;
    private $events;

    public function __construct()
    {
        $this->app = App::instance();
        $this->container = Container::getInstance();
        $this->container->instance('Illuminate\Routing\Contracts\CallableDispatcher', new CallableDispatcher($this->container));
    }

    public function run(): void
    {
        $this->capture();
        $this->router();
        $this->url();
        $this->baseRoutes();
        $this->events();
    }

    private function capture()
    {
        $this->request = BaseRequest::capture();
        $this->container->instance(BaseRequest::class, $this->request);
    }

    private function router()
    {
        $this->events = app('dispatcher');
        $this->router = new Router($this->events, $this->container);
        Route::swap($this->router);
        container("router", $this->router);
        container("request", $this->request);
    }

    private function url()
    {
        $this->app->url = $this->url = new UrlGenerator($this->router->getRoutes(), $this->request);
        container('redirector', new Redirector($this->url));
    }

    private function baseRoutes()
    {
        $router = $this->router;

        if (file_exists(BASEDIR . "/router.php"))
            require_once BASEDIR . '/router.php';
    }

    private function events()
    {
        $router = $this->router;

        bind('before.dispatch', function () use ($router) {
            if (class_exists(Kernel::class)) {
                if (method_exists(Kernel::class, 'handleAliases'))
                    Kernel::handleAliases($router);

                if (method_exists(Kernel::class, 'handleGlobals'))
                    Kernel::handleGlobals($router);
            }
        });
    }
}