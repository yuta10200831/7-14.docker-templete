<?php

namespace App\Domain\Port;

use App\Domain\Entity\Category;

interface ICategoryEditCommand
{
    public function update(Category $category): bool;
    public function findById(int $id): ?array;
}