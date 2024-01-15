<?php

namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\Entity\Post;
use \PDO;


final class PostDao
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

    //DBへ登録をする
    public function save(Post $post): int
    {
        $sql = "INSERT INTO tasks (contents, deadline, category_id) VALUES (:contents, :deadline, :category_id)";
        $stmt = $this->pdo->prepare($sql);

        $title = $post->title()->getValue();
        $contents = $post->contents()->getValue();
        $user_id = $post->userId();

        $stmt->bindParam(':contents', $contents);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':category_id', $category_id);

        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
}
?>