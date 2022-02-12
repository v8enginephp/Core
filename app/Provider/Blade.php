<?php

namespace App\Provider;

use App\Interfaces\Provider;
use Core\View;
use App\Helper\View\{Content, Footer, Notice, Script, Style};
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Blade as BaseBlade;

class Blade implements Provider
{

    public function run(): void
    {
        $this->props();
        $this->facades();
        $this->shutdown();
    }

    private function props()
    {
        View::setProps([
            "content" => new Content,
            "footer" => new Footer,
            "notices" => new Notice,
            "styles" => new Style,
            "scripts" => new Script
        ]);
    }

    private function facades()
    {
        Response::swap(container('response', new ResponseFactory(View::instance()->viewFactory, app('redirector'))));
        BaseBlade::swap(View::instance()->blade);
    }

    private function shutdown()
    {
        register_shutdown_function(function () {
            listen('shutdown', app());
            /**
             * @var $notices Notice
             */
            $notices = prop('notices');
            if (request()->ajax() and $notices != @$_SESSION['notices'])
                $_SESSION['notices'] = $notices;
            else
                $_SESSION['notices'] = [];
        });
    }
}