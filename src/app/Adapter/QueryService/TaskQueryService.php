<?php

namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\TaskDao;
use App\Domain\Entity\Task;
use App\Domain\Port\ITaskQuery;

class TaskQueryService implements ITaskQuery {
    private $taskDao;

    public function __construct(TaskDao $taskDao) {
        $this->taskDao = $taskDao;
    }

    public function findTaskById($id): ?Task {
        $taskData = $this->taskDao->findTaskById($id);
        if (!$taskData) {
            return null;
        }

        return new Task(
            $taskData['id'],
            $taskData['contents'],
            new \DateTimeImmutable($taskData['deadline']),
            $taskData['status'],
            $taskData['category_id']
        );
    }

    public function findAllTasks(): array {
        $tasksData = $this->taskDao->findAllTasks();
        $tasks = [];

        foreach ($tasksData as $taskData) {
            $tasks[] = new Task(
                $taskData['id'],
                $taskData['contents'],
                new \DateTimeImmutable($taskData['deadline']),
                $taskData['status'],
                $taskData['category_id']
            );
        }

        return $tasks;
    }
}
?>