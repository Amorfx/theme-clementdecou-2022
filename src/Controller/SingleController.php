<?php

namespace Theme2022\Controller;

use Simply\Mvc\Attribute\Route;
use Simply\Mvc\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Theme2022\Models\Post;
use Theme2022\Repository\PostRepository;
use Simply\Core\Query\SimplyQuery;

class SingleController extends AbstractController {
    #[Route('single')]
    public function post(PostRepository $postRepository): Response {
        /** @var Post $currentPost */
        $currentPost = SimplyQuery::getCurrentObject();
        return $this->render('single/post.html.twig', [
            'currentPost' => $currentPost,
            'postTags' => $currentPost->getTags(),
            'relatedPosts' => $postRepository->getRelatedPosts($currentPost->getID(), ['limit' => 3]),
        ]);
    }
}
