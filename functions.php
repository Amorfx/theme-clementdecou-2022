<?php

use Theme2022\ThemePlugin;

$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
}
Simply::registerTheme(__DIR__, 'Theme2022');
Simply::registerSimplyPlugin(new ThemePlugin());

// Add theme supports
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );add_theme_support( 'menus' );
// image sizes
add_image_size('grid', 350);

// function condition
function cd_is_tax() {
    return is_category() || is_tag();
}
