<?php

use App\Helper\Template;


$templates = collect(array_merge(config("templates"), [Template::class]));
/*
 * Template List Container
 */
container("templates", collect([]));

/*
 * Register Templates
 */
$templates->each(function ($template) {
    /**
     * @var $template Template
     */
    template($template::getTemplateTitle(), new $template());
});

menu("config", lang('base.settings', 'Settings'), url("dashboard/config"), '', "admin.configs", "icon-settings", 9);