<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CategoryReadInput;
use App\UseCase\UseCaseOutput\CategoryReadOutput;
use App\Infrastructure\Dao\CategoryDao;
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

      return new CategoryReadOutput(true, $categories, "カテゴリ取得成功");
  }
}