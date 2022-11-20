<?php

namespace Theme2022\Models;

use Simply\Core\Model\CategoryObject;
use Simply\Core\Model\ModelFactory;
use Simply\Core\Model\PostTypeObject;

class Post extends PostTypeObject {
    /** @var CategoryObject */
    private $category;

    public function getMainCategory() {
        if (is_null($this->category)) {
            $postCategories = $this->getCategories();
            if (class_exists('WPSEO_Primary_Term')) {
                // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
                $wpseo_primary_term = new \WPSEO_Primary_Term( 'category', $this->getID() );
                $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                if ($wpseo_primary_term) {
                    $this->category = ModelFactory::create(get_term( $wpseo_primary_term ));
                } else {
                    $this->category = $postCategories[0];
                }
            } else {
                $this->category = $postCategories[0];
            }
        }
        return $this->category;
    }

    public function getChapo() {
        return get_field('post_chapo', $this->post);
    }

    public function displayContentClass() {
        if ($this->hasSidebar()) {
            return 'has-sidebar';
        }
        return '';
    }

    public function hasSidebar() {
        return !get_field('article-hide-sidebar', $this->post);
    }

    public static function getType() {
        return 'post';
    }
}
