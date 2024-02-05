<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\SearchKeyword;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;

class TaskInput {
    private $searchKeyword;
    private $deadline;
    private $categoryId;
    private $status;
    private $order;

    public function __construct(SearchKeyword $searchKeyword, Deadline $deadline, CategoryId $categoryId, string $status = '', string $order = 'new') {
        $this->searchKeyword = $searchKeyword;
        $this->deadline = $deadline;
        $this->categoryId = $categoryId;
        $this->status = $status;
        $this->order = $order;
    }

    public function getSearchKeyword(): SearchKeyword {
        return $this->searchKeyword;
    }

    public function getDeadline(): Deadline {
        return $this->deadline;
    }

    public function getCategoryId(): CategoryId {
        return $this->categoryId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getOrder() {
        return $this->order;
    }
}