<?php

namespace Theme2022\Admin;

use Theme2022\Admin\Ajax\GenerateApiToken;
use Theme2022\Admin\Fields\TokenGenerationField;
use Simply\Core\Contract\HookableInterface;

class Admin implements HookableInterface {
    public function register() {
        if (is_admin()) {
            self::initAcfAdmin();
            GenerateApiToken::init();
            self::addNavMenus();
        }
    }

    public static function initAcfAdmin() {
        add_action('acf/init', function () {
            acf_add_options_page(array(
                'page_title'    => 'Theme settings',
                'menu_title'    => 'Theme Settings',
                'menu_slug'     => 'theme-general-settings',
                'capability'    => 'edit_posts',
            ));
        });
        add_action('acf/include_field_types', function() {
            new TokenGenerationField();
        });
    }

    public static function addNavMenus() {
        ThemeMenu::addNavMenus();
    }
}
