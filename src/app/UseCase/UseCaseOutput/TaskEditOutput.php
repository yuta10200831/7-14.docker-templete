<?php

namespace App\Application\UseCase\Output;

class TaskEditOutput {
    private $success;

    public function __construct(bool $success) {
        $this->success = $success;
    }

    public function isSuccess(): bool {
        return $this->success;
    }
}