<?php

use Whoops\{Run, Handler\PrettyPageHandler, Handler\JsonResponseHandler};

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();
//register_shutdown_function(function () {
//    $whoops = app('whoops');
//    $whoops->pushHandler(new JsonResponseHandler());
//    $whoops->register();
//});