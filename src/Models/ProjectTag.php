<?php

namespace Theme2022\Models;

use Theme2022\Repository\ProjectTagRepository;
use Simply\Core\Model\TermObject;

final class ProjectTag extends TermObject {
    static function getRepository() {
        return \Simply::get(ProjectTagRepository::class);
    }

    static function getType() {
        return 'project_tag';
    }
}
