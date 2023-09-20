<?php
// データベース接続
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$error_messages = [];

  $name = $_POST['name'] ?? '';

  // バリデーション
  if (empty($name)) {
    $error_messages[] = 'カテゴリ名が入力されていません';
  }

  if (!empty($error_messages)) {
    header('Location: /category/index.php?error=' . urlencode(implode(', ', $error_messages)));
    exit;

}

$stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->execute();

header("Location: /category/index.php");
exit;
