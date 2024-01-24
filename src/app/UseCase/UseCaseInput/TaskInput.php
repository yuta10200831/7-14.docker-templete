<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\SearchKeyword;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;

class TaskInput {
    private $searchKeyword;
    private $deadline;
    private $categoryId;

    public function __construct(SearchKeyword $searchKeyword, Deadline $deadline, CategoryId $categoryId) {

        $this->searchKeyword = $searchKeyword;
        $this->deadline = $deadline;
        $this->categoryId = $categoryId;
    }

    public function getContents(): SearchKeyword {
        return $this->searchKeyword;
    }

    public function getDeadline(): Deadline {
        return $this->deadline;
    }

    public function getCategoryId(): CategoryId {
        return $this->categoryId;
    }
}
