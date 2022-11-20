<?php

namespace Theme2022\Controller;

use Simply\Mvc\Attribute\Route;
use Simply\Mvc\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController {
    public function getDefaultData(): array {
        return [
            'page_title' => get_the_title(),
        ];
    }

    #[Route('page')]
    public function index(): Response {
        return $this->render('page/index.html.twig', $this->getDefaultData());
    }

    #[Route('page-contact')]
    public function contact(): Response {
        $data = $this->getDefaultData();
        return $this->render('page/contact.html.twig', $data);
    }
}
