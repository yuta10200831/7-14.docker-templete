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
        try {
            $id = $this->input->getId();
            $categoryName = $this->input->getName();
            $userId = $this->input->getUserId();

            $category = $this->iCategoryEditCommand->findById($id);

            if (!$category) {
                return new CategoryEditOutput(false, "指定されたカテゴリが見つかりません。");
            }
            $category->categoryName = $categoryName;
            $category->userId = $userId;

            $result = $this->iCategoryEditCommand->update($category);

            return new CategoryEditOutput(true, "カテゴリが正常に編集されました");
        } catch (\Exception $e) {
            return new CategoryEditOutput(false, "カテゴリの編集に失敗しました: " . $e->getMessage());
        }
    }
}