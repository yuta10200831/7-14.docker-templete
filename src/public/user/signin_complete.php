<?php
session_start();
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

// 入力が不足している場合
if (!$email || !$password) {
  $_SESSION['error_message'] = 'パスワードとメールアドレスを入力してください';
  header('Location: /user/signin.php');
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch();

// ユーザが存在しない、またはパスワードが一致しない場合
if (!$user || !password_verify($password, $user['password'])) {
  $_SESSION['error_message'] = 'メールアドレスまたはパスワードが違います';
  header('Location: /user/signin.php');
  exit;
}

// セッションなどでログイン状態を管理
$_SESSION['username'] = $user['name'];
header('Location: /index.php');
exit;
?>
