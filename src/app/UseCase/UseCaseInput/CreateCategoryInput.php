<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;

class CreateCategoryInput {
    private $name;
    private $userId;

    public function __construct(CategoryName $name, UserId $userId) {
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getName(): CategoryName {
        return $this->name;
    }

    public function getUserId(): UserId {
        return $this->userId;
    }
}
?>