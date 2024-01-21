<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Entity\Category;
use App\Domain\Port\ICategoryCommand;
use App\UseCase\UseCaseInput\CreateCategoryInput;
use App\UseCase\UseCaseOutput\CreateCategoryOutput;

class CreateCategoryInteractor {
    private $categoryCommand;
    private $input;

    public function __construct(ICategoryCommand $categoryCommand, CreateCategoryInput $input) {
        $this->categoryCommand = $categoryCommand;
        $this->input = $input;
    }

    public function handle(): CreateCategoryOutput {
        try {
            $category = new Category($this->input->getName(), $this->input->getUserId());
            $categoryId = $this->categoryCommand->create($category);

            return new CreateCategoryOutput(true, "カテゴリが正常に作成されました");
        } catch (\Exception $e) {
            return new CreateCategoryOutput(false, $e->getMessage());
        }
    }
}
?>