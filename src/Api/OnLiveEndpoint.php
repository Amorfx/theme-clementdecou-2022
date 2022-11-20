<?php

namespace Theme2022\Api;

use Theme2022\Admin\Ajax\GenerateApiToken;
use Theme2022\Admin\ThemeSettings;
use Simply\Core\Contract\HookableInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

class OnLiveEndpoint implements HookableInterface, ServiceSubscriberInterface {
    use ServiceSubscriberTrait;

    public function register() {
        add_action( 'rest_api_init', [$this, 'registerEndpoint']);
    }

    public function registerEndpoint() {
        register_rest_route( 'theme/v1/', '/settings/switch-live', array(
            'methods'  => \WP_REST_Server::EDITABLE,
            'permission_callback' => [$this, 'canSwitchLive'],
            'callback' => [$this, 'switchOnLive'],
        ) );
    }

    public function canSwitchLive(): bool {
        $token = $_POST['token'];
        $activeToken = get_option(GenerateApiToken::$tokenOptionKey);
        return wp_check_password($token, $activeToken) && $this->getTokenGenerator()->isExpireToken($token) === false;
    }

    public function switchOnLive() {
        $onLive = ThemeSettings::isLive();
        update_field('cd_theme-settings_is-live', !$onLive, 'option');
        echo json_encode(['success' => true, 'onLive' => !$onLive]);
    }

    public function getTokenGenerator(): TokenGenerator {
        return $this->container->get(TokenGenerator::class);
    }

    public static function getSubscribedServices(): array {
        return [TokenGenerator::class => TokenGenerator::class];
    }
}
