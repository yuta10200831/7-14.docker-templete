<?php

$id = $_POST['id'] ?? null;
$contents = $_POST['contents'] ?? null;
$deadline = $_POST['deadline'] ?? null;
$category_id = $_POST['category_id'] ?? null;
$errors = [];

// 各種エラーチェック
if ($id === null) {
    header('Location: edit.php?error=' . urlencode('IDが指定されていません'));
    exit;
}

if (empty($category_id)) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode('カテゴリが選択されていません'));
    exit;
}

if (empty($contents)) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode('タスク名が入力されていません'));
    exit;
}

if (empty($deadline)) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode('締切日が入力されていません'));
    exit;
}

$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$stmt = $pdo->prepare("UPDATE tasks SET contents = :contents, deadline = :deadline, category_id = :category_id WHERE id = :id");
$result = $stmt->execute([
  ':id' => $id,
  ':contents' => $contents,
  ':deadline' => $deadline,
  ':category_id' => $category_id
]);

if (!$result) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode('データの更新に失敗しました'));
    exit;
}

header('Location: /index.php');
exit;
?>
