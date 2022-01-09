<?php
namespace App\Provider;

use Core\{App, Translation};
use App\Interfaces\Provider;

class I18N implements Provider
{
    public function run(): void
    {
        $translator = Translation::instance();
        $locales = config("locales");
        foreach ($locales as $locale) {
            $translator->registerTranslator($locale);
        }
        App::setLocale(env("LOCALE", $locales[0]));
    }
}