<?php

namespace App\UseCase\UseCaseOutput;

class TaskOutput {
    private $success;
    private $message;
    private $tasks;

    public function __construct(bool $success, string $message, array $tasks = []) {
        $this->success = $success;
        $this->message = $message;
        $this->tasks = $tasks;
    }

    public function isSuccess(): bool {
        return $this->success;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getTasks(): array {
        return $this->tasks;
    }
}
