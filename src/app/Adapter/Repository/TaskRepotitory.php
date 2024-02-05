<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Task;
use App\Domain\Port\ITaskCommand;
use App\Infrastructure\Dao\TaskDao;

class TaskRepository implements ITaskCommand {
    private $TaskDao;

    public function __construct(TaskDao $taskDao) {
        $this->taskDao = $taskDao;
    }

    public function updateTask(Task $task): bool {
        return $this->dao->updateTask($task);
    }
}