<?php

namespace App\Domain\Port;

use App\Domain\Entity\Task;

interface ITaskCommand {
    public function updateTask(Task $task): bool;
}