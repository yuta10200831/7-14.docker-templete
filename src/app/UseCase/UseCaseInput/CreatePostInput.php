<?php

namespace App\UseCase\UseCaseInput;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;

final class CreatePostInput
{
    private $contents;
    private $deadline;
    private $user_id;

    public function __construct(Contents $contents, Deadline $deadline, string $user_id)
    {
        $this->contents = $contents;
        $this->deadline = $deadline;
        $this->user_id = $user_id;
    }

    public function getContents(): Contents {
        return $this->contents;
    }

    public function getDeadline(): Deadline {
        return $this->deadline;
    }

    public function getUserId(): string {
        return $this->user_id;
    }
}
?>