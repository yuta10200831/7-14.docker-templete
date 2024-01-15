<?php

namespace App\Domain\Entity;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

final class Post
{
    private $title;
    private $contents;
    private $userId;

    public function __construct(Title $title, Contents $contents, string $userId)
    {
        $this->title = $title;
        $this->contents = $contents;
        $this->userId = $userId;
    }

    public function title(): Title {
        return $this->title;
    }

    public function contents(): Contents {
        return $this->contents;
    }

    public function userId(): string {
        return $this->userId;
    }
}
?>