<?php

namespace App\Infrastructure\Dao;

use App\Domain\Entity\Task;
use \PDO;
use \Exception;

class TaskDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=todo;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (\PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function findTaskById(int $id): ?Task {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('SQL実行エラー');
        }

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new Task(
            $data['id'],
            $data['contents'],
            $data['deadline'],
            $data['status'],
            $data['category_id']
        );
    }

    public function findAllTasks(): array {
        $sql = "SELECT * FROM tasks";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new Exception('SQL実行エラー');
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
