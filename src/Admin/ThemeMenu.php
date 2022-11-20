<?php


namespace Theme2022\Admin;

class ThemeMenu {
    static $headerNavSlug = 'header';

    public static function addNavMenus() {
        add_action('init', function() {
            register_nav_menus([
                self::$headerNavSlug => 'Header menu'
            ]);
        });

        add_action('wp_update_nav_menu', self::class . '::deleteCache');
    }

    public static function deleteCache($menuID) {
        \Simply::get('framework.cache')->delete('menu:' . self::$headerNavSlug);
    }
}
