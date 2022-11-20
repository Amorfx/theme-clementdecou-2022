<?php

namespace Theme2022\Repository;

use Simply\Core\Repository\TermRepository;
use Theme2022\Models\ProjectTag;

final class ProjectTagRepository extends TermRepository {
    public function getClassName() {
        return ProjectTag::class;
    }

    protected function getTaxonomy() {
        return ProjectTag::getType();
    }
}
