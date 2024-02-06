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

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    public function findAllByUserId(int $userId): array {
        $sql = "SELECT * FROM categories WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isCategoryInUse(int $categoryId): bool {
        $sql = "SELECT COUNT(*) FROM tasks WHERE category_id = :category_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function findById(int $id): ?array
{
    $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    return $category ?: null;
}

    public function update(Category $category): bool
    {
        $sql = "UPDATE categories SET name = :name, user_id = :user_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $name = $category->getName()->getValue();
        $userId = $category->getUserId()->value();
        $id = $category->getId();

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}