<?php

namespace Theme2022;

use Simply\Core\Contract\PluginInterface;
use Simply\Core\Contract\RegisterModelInterface;
use Simply\Core\Model\ModelFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Theme2022\Models\Post;
use Theme2022\Models\Project;
use Theme2022\Models\ProjectTag;

class ThemePlugin implements PluginInterface, RegisterModelInterface {
    public function build(ContainerBuilder $container): void {}

    public function registerModel(ModelFactory $factory): void {
        $factory->registerPostModel(array(Project::class, Post::class));
        $factory->registerTermModel(array(ProjectTag::class));
    }
}
