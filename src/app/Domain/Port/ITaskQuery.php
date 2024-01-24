<?php

namespace App\Domain\Port;

use App\Domain\Entity\Task;

interface ITaskQuery
{
    public function findTaskById($id): ?Task;
    public function findAllTasks(): array;
}
?>