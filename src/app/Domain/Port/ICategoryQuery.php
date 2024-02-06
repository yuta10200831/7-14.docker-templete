<?php
namespace App\Domain\Port;

use App\Domain\Entity\Category;

interface ICategoryQuery
{
    public function findAll(): array;
    public function isCategoryInUse(int $categoryId): bool;
}