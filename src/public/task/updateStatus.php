<?php

    $id = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null;

    if (is_null($id) || is_null($status)) {
        header("Location: /index.php");
        exit;
    }

    $new_status = $status == 0 ? 1 : 0;

    $pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);

    header("Location: /index.php");
    exit;
?>

