<?php

use App\Provider\Blade;
use App\Provider\Bootstrap;
use App\Provider\Eloquent;
use App\Provider\Env;
use App\Provider\I18N;
use App\Provider\Module;
use App\Provider\Request;
use App\Provider\Template;
use App\Provider\Validator;

return [
//    /*
//     * Whoops
//     */
//    "Whoops" => "whoops",

    /*
     * Load Env
     */
    "env" => Env::class,

//    /*
//     * initialize Basics
//     */
//    "Core" => "core",

//    /*
//     * Create Redis Connection
//     */
//    "Redis" => "redis",

    /*
     * Create Database Connection
     */
    "database" => Eloquent::class,

    /*
     * Config Request Router
     */
    "request" => Request::class,

    /*
     * Set Translator for Project
     */
    "i18n" => I18N::class,

    /*
     * Request Validator
     */
    "validator" => Validator::class,

    /*
     * Default View Properties
     */
    "view" => Blade::class,

    /*
     * init user providers
     */
    "provider" => Bootstrap::class,

    /*
     * Load Templates
     */
    "template" => Template::class,

    /*
     * Run Modules
     */
    "module" => Module::class,
];
