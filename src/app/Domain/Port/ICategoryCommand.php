<?php

namespace App\Domain\Port;

use App\Domain\Entity\Category;

interface ICategoryCommand {
    public function create(Category $category): int;
}
?>