<?php

namespace App\Adapter\Repository;
use App\Infrastructure\Dao\CategoryDao;
use App\Domain\Entity\Category;
use App\Domain\Port\ICategoryCommand;
use App\Domain\Port\ICategoryEditCommand;

final class CategoryRepository implements ICategoryCommand, ICategoryEditCommand
{
    private $categoryDao;

    public function __construct(CategoryDao $categoryDao)
    {
        $this->categoryDao = $categoryDao;
    }

    public function create(Category $category): int
    {
        return $this->categoryDao->create($category);
    }

    public function update(Category $category): bool
    {
        return $this->categoryDao->update($category);
    }

    public function findById(int $id): ?array
    {
        return $this->categoryDao->findById($id);
    }
}