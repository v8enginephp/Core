<?php

namespace App\Provider;


use App\Interfaces\Provider;
use Core\App;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Builder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class Eloquent implements Provider
{
    private $connection;

    public function run(): void
    {
        $this->connection = new Manager();
        $this->connection->addConnection(config("database"));
        $this->connection->setEventDispatcher(container('dispatcher', new Dispatcher(Container::getInstance())));
        $this->connection->setAsGlobal();
        $this->connection->bootEloquent();

        App::setConnection($this->connection);

        Builder::defaultStringLength(191);

        $this->queryLog(env("DEBUG", false));
        $this->DB();
    }

    private function queryLog($status = false)
    {
        if ($status)
            Manager::enableQueryLog();
    }

    private function DB()
    {
        DB::swap($this->connection);
    }
}