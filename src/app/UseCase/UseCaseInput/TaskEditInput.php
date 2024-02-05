<?php

namespace App\Application\UseCase\UseCaseInput;

class TaskEditInput {
    private $id;
    private $contents;
    private $deadline;
    private $categoryId;
    private $status;

    public function __construct(int $id, string $contents, string $deadline, int $categoryId, int $status) {
        $this->id = $id;
        $this->contents = $contents;
        $this->deadline = $deadline;
        $this->categoryId = $categoryId;
        $this->status = $status;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getContents(): string {
        return $this->contents;
    }

    public function getDeadline(): string {
        return $this->deadline;
    }

    public function getCategoryId(): int {
        return $this->categoryId;
    }

    public function getStatus(): int {
        return $this->status;
    }
}