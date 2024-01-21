<?php

namespace App\Adapter\Repository;
use App\Infrastructure\Dao\CategoryDao;
use App\Domain\Entity\Category;
use App\Domain\Port\ICategoryCommand;

final class CategoryRepository implements ICategoryCommand
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
}
?>