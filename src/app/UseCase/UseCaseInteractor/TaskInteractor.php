<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ITaskQuery;
use App\UseCase\UseCaseInput\TaskInput;
use App\UseCase\UseCaseOutput\TaskOutput;

final class TaskInteractor {
    private $taskQuery;
    private $input;

    public function __construct(TaskInput $input, ITaskQuery $taskQuery) {
        $this->input = $input;
        $this->taskQuery = $taskQuery;
    }

    public function handle(): TaskOutput {
        try {
            $searchKeywordVo = $this->input->getSearchKeyword();
            $searchKeyword = $searchKeywordVo->value();
            $selectedCategoryIdVo = $this->input->getCategoryId();
            $selectedCategoryId = null;
            if ($selectedCategoryIdVo !== null && $selectedCategoryIdVo->isValid()) {
                $selectedCategoryId = $selectedCategoryIdVo->getValue();
            }
            $status = $this->input->getStatus();
            $order = $this->input->getOrder();

            $tasks = $this->taskQuery->findAllTasks($searchKeyword, $selectedCategoryId, $status, $order);

            return new TaskOutput(true, "タスクの一覧を取得しました。", $tasks);
        } catch (\Exception $exception) {
            return new TaskOutput(false, "タスクの一覧取得に失敗しました: " . $exception->getMessage());
        }
    }
}