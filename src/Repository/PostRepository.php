<?php

namespace Theme2022\Repository;

use Theme2022\Models\Post;
use Simply\Core\Model\ModelFactory;
use Simply\Core\Repository\PostRepository as SimplyPostRepository;

class PostRepository extends SimplyPostRepository {
    /**
     * Use yarpp to get related posts
     * @param int $postID
     *
     * @return array
     */
    public function getRelatedPosts(int $postID = 0, array $args = []) {
        if ($postID < 1 || !function_exists('yarpp_get_related')) {
            return [];
        }

        $relatedArray = yarpp_get_related($args, $postID);
        if (!empty($relatedArray)) {
            foreach ($relatedArray as $key => $aPost) {
                $relatedArray[$key] = ModelFactory::create($aPost);
            }
        }

        return $relatedArray;
    }

    public function getClassName() {
        return Post::class;
    }
}
