<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CategoryReadInput;
use App\UseCase\UseCaseOutput\CategoryReadOutput;
use App\Domain\Port\ICategoryQuery;

class CategoryReadInteractor {
    private $input;
    private $categoryQuery;

    public function __construct(CategoryReadInput $input, ICategoryQuery $categoryQuery) {
        $this->input = $input;
        $this->categoryQuery = $categoryQuery;
    }

    public function handle(): CategoryReadOutput {
        $categories = $this->categoryQuery->findAll();
        $categoriesWithUsage = [];

        foreach ($categories as $category) {
            $isInUse = $this->categoryQuery->isCategoryInUse($category['id']);
            $categoriesWithUsage[] = [
                'category' => $category,
                'isInUse' => $isInUse
            ];
        }

        return new CategoryReadOutput(true, $categoriesWithUsage, "カテゴリ取得成功");
    }
}