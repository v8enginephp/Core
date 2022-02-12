<?php

namespace App\Command;

use App\Helper\Command;

class MakeProvider extends Command
{
    protected $name;

    public function __construct($command, ...$args)
    {
        $this->name = @$args[0];
        $this->dir = BASEDIR . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "Provider";
    }

    public function run()
    {
        $this->putFile($this->name . ".php", $this->stub('provider', ['%name'], [$this->name]));
    }
}