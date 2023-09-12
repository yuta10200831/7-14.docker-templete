<?php
session_start();

// データベースに接続
$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

// 検索キーワードと並び順の初期値を設定
$search_keyword = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'new'; // デフォルトは新しい順

// SQLクエリの準備
$sql = "SELECT id, title, LEFT(contents, 15) AS short_contents, created_at FROM blogs";
$placeholders = [];

if ($search_keyword) {
    $sql .= " WHERE title LIKE :search OR contents LIKE :search";
    $placeholders[':search'] = '%' . $search_keyword . '%';
}

if ($order === 'new') {
    $sql .= " ORDER BY created_at DESC";
} elseif ($order === 'old') {
    $sql .= " ORDER BY created_at ASC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($placeholders);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>ブログ一覧</title>
</head>
<body class="bg-gray-100">

<!-- ヘッダーの表示 -->
<header class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold">Todoアプリ</h2>
        </div>
        <div>
            <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">ホーム</a>
            <!-- 後程遷移先を指定 -->
            <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">カテゴリ一覧</a>
            <?php if (isset($_SESSION["username"])): ?>
                <!-- 後程遷移先を指定 -->
                <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">ログアウト</a>
            <?php else: ?>
                <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">ログイン</a>
            <?php endif; ?>
        </div>
    </div>
</header>

</main>

</body>
</html>