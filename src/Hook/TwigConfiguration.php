<?php

namespace Theme2022\Hook;

use Simply\Core\Attributes\Filter;
use Theme2022\Admin\ThemeSettings;
use Theme2022\Utils\ThemeUtils;
use Twig\Environment;
use Twig\TwigFunction;

class TwigConfiguration {
    #[Filter('simply/config/template')]
    public function addConfig(Environment $twig) {
        $twig->addFunction(new TwigFunction('isLive', ThemeSettings::class . '::isLive'));
        $twig->addGlobal('theme', new ThemeUtils());
        return $twig;
    }
}
