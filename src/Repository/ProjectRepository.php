<?php

namespace Theme2022\Repository;

use Theme2022\Models\Project;
use Simply\Core\Repository\PostRepository;

class ProjectRepository extends PostRepository {
    public function getClassName() {
        return Project::class;
    }
}
