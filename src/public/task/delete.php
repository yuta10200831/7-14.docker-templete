<?php
// データベースへの接続
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

// GETで送られたIDを取得
$id = $_GET['id'] ?? null;

// IDがnullでないかチェック
if ($id === null) {
    header('Location: /index.php?error=' . urlencode('IDが指定されていません'));
    exit;
}

// SQLクエリの準備と実行
$stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
$result = $stmt->execute([':id' => $id]);

// 削除処理が成功したかチェック
if ($result) {
    header('Location: /index.php?message=' . urlencode('タスクを削除しました'));
} else {
    header('Location: /index.php?error=' . urlencode('タスクの削除に失敗しました'));
}

exit;
?>
