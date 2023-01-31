<?php

namespace App\Provider;

use App\Helper\Provider;
use App\Helper\Template as BaseTemplate;


class Template extends Provider
{
    public function run(): void
    {
        $templates = collect(array_merge(config("templates"), [BaseTemplate::class]));
        /*
         * Template List Container
         */
        container("templates", collect([]));

        /*
         * Register Templates
         */
        $templates->each(function ($template) {
            /**
             * @var $template BaseTemplate
             */
            template($template::getTemplateTitle(), new $template());
        });
    }
}