<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;

final class Post
{
    private $contents;
    private $deadline;
    private $categoryId;
    private $userId;

    public function __construct(Contents $contents, Deadline $deadline, CategoryId $categoryId, string $userId)
    {
        $this->contents = $contents;
        $this->deadline = $deadline;
        $this->categoryId = $categoryId;
        $this->userId = $userId;
    }

    public function contents(): Contents {
        return $this->contents;
    }

    public function deadline(): Deadline {
        return $this->deadline;
    }

    public function categoryId(): CategoryId {
        return $this->categoryId;
    }

    public function userId(): string {
        return $this->userId;
    }
}
?>