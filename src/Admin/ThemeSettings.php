<?php

namespace Theme2022\Admin;

use Theme2022\Utils\AcfUtils;
use Simply\Core\Contract\CacheInterface;

class ThemeSettings {
    static $isLive;

    static function getRs() {
        return AcfUtils::getRepeaterOption('cd_theme-settings_rs');
    }

    /**
     * @return boolean
     */
    static function isLive() {
        if (!is_null(self::$isLive)) {
            return self::$isLive;
        }
        self::$isLive = get_field('cd_theme-settings_is-live', 'option');
        return self::$isLive;
    }

    static function getPresentationData(CacheInterface $cache) {
        $contentCache = $cache->get('home-presentation');
        if (!$contentCache) {
            $return =  [
                'mainText' => get_field('cd-_theme-settings_home-presentation', 'option'),
                'subtext' => get_field('cd-_theme-settings_home-sub-presentation', 'option'),
                'callToAction' => get_field('cd-_theme-settings_home-presentation-call-to-action', 'option')
            ];
            $cache->set('home-presentation', $return);
        } else {
            $return = $contentCache;
        }
        return $return;
    }

    static function getHomeServices() {
        return AcfUtils::getRepeaterOption('cd-_theme-settings_home-services');
    }
}
