<?php

namespace Theme2022\Hook;

use Simply\Core\Attributes\Action;

class DequeueScripts {
    // Remove Gutenberg Block Library CSS from loading on the frontend
    #[Action('wp_enqueue_scripts', 100)]
    public function dequeueGutenbergScripts() {
        if (!is_single()) {
            wp_dequeue_style( 'wp-block-library' );
            wp_dequeue_style( 'wp-block-library-theme' );
            wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
        }
    }
}
