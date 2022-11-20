<?php

namespace Theme2022\Controller;

use Simply\Mvc\Attribute\Route;
use Theme2022\Utils\Paginator;
use Simply\Core\Model\TermObject;
use Simply\Core\Query\SimplyQuery;
use Simply\Mvc\Controller\AbstractController;

class BlogController extends AbstractController {
    #[Route('index')]
    public function index() {
        $allPosts = SimplyQuery::getCurrentQuery()->getQueriedPosts();
        $search = get_query_var('s');
        $paginator = new Paginator();
        $currentObject = SimplyQuery::getCurrentObject();
        $isAuthor = is_author();
        return $this->render('page/blog.html.twig', ['allPosts' => $allPosts, 'pagination' => $paginator->generateOptimizedPagination(), 'keywords' => $search, 'isAuthor' => $isAuthor, 'currentObject' => $currentObject]);
    }

    #[Route('index', customCondition: 'cd_is_tax')]
    public function taxonomy() {
        /** @var TermObject $term */
        $term = SimplyQuery::getCurrentObject();
        $allPosts = SimplyQuery::getCurrentQuery()->getQueriedPosts();
        $paginator = new Paginator();
        return $this->render('page/blog.html.twig', ['allPosts' => $allPosts, 'pagination' => $paginator->generateOptimizedPagination(), 'term' => $term]);
    }
}
