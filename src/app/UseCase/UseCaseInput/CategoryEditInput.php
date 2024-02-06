<?php

namespace App\UseCase\UseCaseInput;
use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

class CategoryEditInput
{
    private $name;
    private $userId;
    private $id;

    public function __construct(CategoryName $name, UserId $userId ,int $id) {
      $this->name = $name;
      $this->userId = $userId;
      $this->id = $id;
    }

    public function getName(): CategoryName {
        return $this->name;
    }

    public function getUserId(): UserId {
        return $this->userId;
    }

    public function getId(): int {
      return $this->id;
  }
}