<?php

namespace Theme2022\Controller;

use Simply\Mvc\Attribute\Route;
use Simply\Mvc\Controller\AbstractController;
use Theme2022\Admin\ThemeSettings;
use Theme2022\Repository\ProjectRepository;
use Theme2022\Repository\ProjectTagRepository;
use Simply\Core\Contract\CacheInterface;

class HomeController extends AbstractController {
    #[Route('page-accueil')]
    public function home(ProjectTagRepository $projectTagRepository, ProjectRepository $projectRepository, CacheInterface $cache) {
        return $this->render('page/home.html.twig', [
            'presentation' => ThemeSettings::getPresentationData($cache),
            'services' => ThemeSettings::getHomeServices(),
            'project_tags' => $projectTagRepository->findBy(['hide_empty' => true]),
            'projects' => $projectRepository->findBy([], ['meta_key' => 'cd-project_grid-position', 'order' => 'ASC'])
        ]);
    }
}
