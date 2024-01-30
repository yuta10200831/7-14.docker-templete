<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Category\CategoryName;

class Category {
    private $id;
    private $name;
    private $userId;

    public function __construct(CategoryName $name, UserId $userId) {
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName(): CategoryName {
        return $this->name;
    }

    public function getUserId(): UserId {
        return $this->userId;
    }
}
?>