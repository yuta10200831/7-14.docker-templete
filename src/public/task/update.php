<?php
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$id = $_POST['id'] ?? null;
$contents = $_POST['contents'] ?? null;
$deadline = $_POST['deadline'] ?? null;
$category_id = $_POST['category_id'] ?? null;
$errors = [];

if ($id === null) {
    $errors[] = 'IDが指定されていません';
}

if (empty($category_id)) {
    $errors[] = 'カテゴリが選択されていません';
}

if (empty($contents)) {
    $errors[] = 'タスク名が入力されていません';
}

if (empty($deadline)) {
    $errors[] = '締切日が入力されていません';
}

if (!empty($errors)) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode(implode(',', $errors)));
    exit;
}

// ここからデータを更新する処理を書く
$stmt = $pdo->prepare("UPDATE tasks SET contents = :contents, deadline = :deadline, category_id = :category_id WHERE id = :id");
$result = $stmt->execute([
  ':id' => $id,
  ':contents' => $contents,
  ':deadline' => $deadline,
  ':category_id' => $category_id
]);

if ($result) {
  header('Location: /index.php');
} else {
  $errorInfo = $stmt->errorInfo();
  header('Location: edit.php?id=' . $id . '&error=');
}

exit;
?>
