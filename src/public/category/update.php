<?php
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;

if ($id === null || empty($name)) {
  $errorMessage = empty($name) ? 'カテゴリ名が入力されていません' : '入力されていない項目があります';
  header('Location: /category/edit.php?id=' . $id . '&error=' . urlencode($errorMessage));
  exit;
}

$stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->execute();

header('Location: /category/index.php');
exit;
?>
