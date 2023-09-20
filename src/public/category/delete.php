<?php

$id = $_GET['id'] ?? null;

if ($id === null) {
  header('Location: /category/index.php?error=' . urlencode('IDが指定されていません'));
  exit;
}

$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: /category/index.php');
exit;

?>