<?php
namespace App\Infrastructure\Dao;

use App\Domain\ValueObject\User\NewUser;
use App\Domain\ValueObject\User\Email;
use \PDO;
use \Exception;

class UserDao {
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

    public function findUserByEmail(Email $email): ?array {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email->value(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('SQL実行エラー');
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user === false ? null : $user;
    }

    public function createUser(string $name, string $email, string $hashedPassword): void {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('User could not be created.');
        }
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>