<?php

namespace Theme2022\Models\Menu;

use Simply\Core\Contract\CacheInterface;

class Menu {
    private $location;
    private $items;

    public function __construct(string $location) {
        $this->location = $location;
    }

    public function getItems() {
        $keyCache = 'menu:' . $this->location;
        /** @var CacheInterface $cacheService */
        $cacheService = \Simply::get('framework.cache');
        $contentCache = $cacheService->get($keyCache);
        if (!$contentCache) {
            $menuID = get_nav_menu_locations()[$this->location];
            $this->items = wp_get_nav_menu_items($menuID);
            $cacheService->set($keyCache, $this->items);
        } else {
            $this->items = $contentCache;
        }

        // get current url
        global $wp;
        $currentUrl = home_url( $wp->request );
        foreach ($this->items as $key => $anItem) {
            if (trim($anItem->url, '/') === $currentUrl) {
                $anItem->isCurrent = true;
            } else {
                $anItem->isCurrent = false;
            }
            $this->items[$key] = $anItem;
        }

        return $this->items;
    }
}
