<?php

namespace App\Infrastructure\Dao;

use App\Domain\Entity\Task;
use PDO;
use Exception;

class TaskDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=todo;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (PDOException $e) {
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

    public function findAllTasks($searchKeyword = '', $selectedCategoryId = '', $status = '', $order = 'new'): array {
        $parameters = [];
        $sql = "SELECT * FROM tasks WHERE 1=1";

        if ($searchKeyword !== '') {
            $sql .= " AND contents LIKE :searchKeyword";
            $parameters[':searchKeyword'] = '%' . $searchKeyword . '%';
        }

        if ($selectedCategoryId !== '' && is_numeric($selectedCategoryId) && $selectedCategoryId > 0) {
            $sql .= " AND category_id = :categoryId";
            $parameters[':categoryId'] = $selectedCategoryId;
        }

        if ($status === 'complete') {
            $sql .= " AND status = 1";
        } elseif ($status === 'incomplete') {
            $sql .= " AND status = 0";
        }

        if ($order === 'old') {
            $sql .= " ORDER BY deadline ASC";
        } else {
            $sql .= " ORDER BY deadline DESC";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($parameters as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        if (!$stmt->execute()) {
            throw new Exception('SQL実行エラー');
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}