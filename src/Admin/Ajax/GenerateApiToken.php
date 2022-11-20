<?php

namespace Theme2022\Admin\Ajax;

use Theme2022\Api\TokenGenerator;

class GenerateApiToken {
    public static $tokenOptionKey = 'cd_api_token';
    public static function init() {
        add_action('wp_ajax_generateApiToken', function() {
            header('Content-Type: application/json');
            /** @var TokenGenerator $tokenGenerator */
            $tokenGenerator = \Simply::get(TokenGenerator::class);
            $data = ['action' => 'themeApi'];
            $token = $tokenGenerator->generate($data, true, 'P6M');
            update_option(self::$tokenOptionKey, wp_hash_password($token), false);
            echo json_encode(['token' => $token]);
            exit();
        });
    }
}
