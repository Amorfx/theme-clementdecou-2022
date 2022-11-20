<?php

namespace Theme2022\Hook;

use Simply\Core\Contract\HookableInterface;

class Excerpt implements HookableInterface {
    public function register() {
        add_action('excerpt_length', function($length) {
            if (is_home()) {
                return 20;
            }
           return $length;
        });

        add_action('excerpt_more', function($more) {
            if (is_home()) {
                return '...';
            }
            return $more;
        });
    }
}
