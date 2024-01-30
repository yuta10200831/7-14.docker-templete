<?php

namespace App\Infrastructure\Dao;
use App\Domain\Entity\Category;
use PDO;

final class CategoryDao
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=todo;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (PDOException $e) {
            exit('DB接続エラー:' . $e->getMessage());
        }
    }

    public function create(Category $category): int
    {
        $sql = "INSERT INTO categories (name, user_id) VALUES (:name, :user_id)";
        $stmt = $this->pdo->prepare($sql);

        $name = $category->getName()->getValue();
        $userId = $category->getUserId()->value();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
?>