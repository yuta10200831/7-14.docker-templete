<?php

$error_messages = [];

  $contents = $_POST['contents'] ?? '';
  $deadline = $_POST['deadline'] ?? '';
  $category_id = $_POST['category_id'] ?? null;

  // バリデーション
  if (empty($contents)) $error_messages[] = "タスク名が入力されていません";
  if (empty($deadline)) $error_messages[] = "締切日が入力されていません";
  if (is_null($category_id)) $error_messages[] = "カテゴリが選択されていません";

  if (!empty($error_messages)) {
    header("Location: /task/create.php?error=" . urlencode(implode(', ', $error_messages)));
    exit;
  }

  $pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');
  $stmt = $pdo->prepare("INSERT INTO tasks (contents, deadline, category_id) VALUES (?, ?, ?)");
  $stmt->execute([$contents, $deadline, $category_id]);

  header("Location: /index.php");
  exit;
