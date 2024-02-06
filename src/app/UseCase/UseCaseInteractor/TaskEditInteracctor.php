<?php

namespace App\Application\UseCase;

use App\Domain\Port\ITaskCommand;
use App\Application\UseCase\UseCaseInput\TaskEditInput;
use App\Application\UseCase\UseCaseOutput\TaskEditOutput;
use App\Domain\Entity\Task;

class TaskEditInteractor {
    private $taskCommand;
    private $input;

    public function __construct(ITaskCommand $taskCommand, TaskEditInput $input) {
        $this->taskCommand = $taskCommand;
        $this->input = $input;
    }

    public function handle(): TaskEditOutput {
        $task = new Task(
            $this->input->getId(),
            $this->input->getContents(),
            new \DateTime($this->input->getDeadline()),
            $this->input->getStatus(),
            $this->input->getCategoryId()
        );

        $result = $this->taskCommand->updateTask($task);

        return new TaskEditOutput($result);
    }
}