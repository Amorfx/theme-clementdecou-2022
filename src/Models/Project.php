<?php

namespace Theme2022\Models;

use Simply\Core\Model\PostTypeObject;

class Project extends PostTypeObject {
    private $tags;
    private $gridSize;

    public function getProjectTags() {
        if (!is_null($this->tags)) {
            return $this->tags;
        }
        $this->tags = get_the_terms($this->post, 'project_tag');
        return $this->tags;
    }

    /**
     * @return array
     */
    public function getGridInfos(): array {
        return [
            'img' => $this->getGridImg(),
            'subtitle' => $this->getHomeSubtitle(),
            'gridSize' => $this->getGridSize(),
            'url' => $this->getGridUrl(),
        ];
    }

    /**
     * Get term name for Isotope filter in home page
     * @return array
     */
    public function getClassFilterForIsotope() {
        $tags = $this->getProjectTags();
        $class = [];
        foreach ($tags as $aTerm) {
            $class[] = $aTerm->slug;
        }
        return $class;
    }

    /**
     * @return false|string
     */
    public function getGridImg() {
        $size = $this->getGridSize();
        $thumbnailSize = 'medium_large';
        if ($size == 'medium' || $size == 'small') {
            $thumbnailSize = 'grid';
        }
        return get_the_post_thumbnail_url($this->post->ID, $thumbnailSize);
    }

    /**
     * In home grid the project can have external link
     * So get external link or permalink)
     * @return false|mixed|string|\WP_Error
     */
    public function getGridUrl() {
        $link = get_field('cd-project_url', $this->post->ID);
        if ($link) {
            return $link;
        }

        return $this->getPermalink();
    }

    public function getHomeSubtitle() {
        return get_field('cd-project_home-subtitle', $this->post->ID);
    }

    public function getGridSize() {
        if (!is_null($this->gridSize)) {
            return $this->gridSize;
        }
        $this->gridSize = get_field('cd-project_grid-size', $this->post->ID);
        return $this->gridSize;
    }

    public static function getType() {
        return 'project';
    }
}
