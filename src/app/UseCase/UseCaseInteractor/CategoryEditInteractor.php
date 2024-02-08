<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CategoryEditInput;
use App\UseCase\UseCaseOutput\CategoryEditOutput;
use App\Domain\Entity\Category;
use App\Domain\Port\ICategoryEditCommand;

class CategoryEditInteractor
{
    private $categoryRepository;

    public function __construct(CategoryEditInput $input, ICategoryEditCommand $iCategoryEditCommand)
    {
        $this->input = $input;
        $this->iCategoryEditCommand = $iCategoryEditCommand;
    }

    public function handle(): CategoryEditOutput
    {
        $id = $this->input->getId();
        $categoryName = $this->input->getName();
        $userId = $this->input->getUserId();

        $categoryData = $this->iCategoryEditCommand->findById($id);

        if (!$categoryData) {
            return new CategoryEditOutput(false, "指定されたカテゴリが見つかりません。");
        }

        $category = new Category($categoryName, $userId);
        $category->setId($id);

        $result = $this->iCategoryEditCommand->update($category);

        if ($result) {
            return new CategoryEditOutput(true, "カテゴリが正常に編集されました");
        } else {
            return new CategoryEditOutput(false, "カテゴリの編集に失敗しました");
        }
    }
}