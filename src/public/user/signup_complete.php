<?php
session_start();
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$password_confirm = $_POST['password_confirm'] ?? null;

if (!$name || !$email || !$password || !$password_confirm) {
  $_SESSION['error_message'] = 'EmailかPasswordの入力がありません';
  header('Location: signup.php');
  exit;
}

if ($password !== $password_confirm) {
  $_SESSION['error_message'] = 'パスワードが一致しません';
  header('Location: signup.php');
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$existingUser = $stmt->fetch();

if ($existingUser) {
  $_SESSION['error_message'] = 'すでに保存されているメールアドレスです';
  header('Location: signup.php');
  exit;
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
$stmt->execute();

header('Location: signin.php');
exit;
?>
