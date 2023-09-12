<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$sql = "SELECT tasks.title, tasks.contents, categories.name AS category FROM tasks JOIN categories ON tasks.category_id = categories.id";
$statement = $pdo->prepare($sql);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    <!-- メインコンテンツ -->
    <main class="container mx-auto mt-4 p-4">
    <h1 class="text-lg font-semibold">絞り込み検索</h1>
        <!-- 絞り込み検索とソート -->
        <div class="mb-4">
            <form method="GET" action="/index.php" class="flex items-center space-x-4">
                <input type="text" name="search" class="p-2 border rounded" placeholder="キーワードを入力">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">検索</button>

          <!-- ソートボタン -->
          <div>
              <input type="radio" id="new" name="order" value="new" class="form-radio">
              <label for="new" class="mr-2">新しい順</label>
              <br>
              <input type="radio" id="old" name="order" value="old" class="form-radio">
              <label for="old">古い順</label>
          </div>
              <!-- カテゴリ検索 -->
              <select name="category" class="p-2 border rounded">
                  <option value="">カテゴリ</option>
                  <!-- ここにPHPでカテゴリを動的に生成 -->
              </select>
              <!-- 完了未完了 -->
          <div>
            <input type="radio" id="complete" name="status" value="complete" class="form-radio">
            <label for="complete" class="mr-2">完了</label>
            <br>
            <input type="radio" id="incomplete" name="status" value="incomplete" class="form-radio">
            <label for="incomplete">未完了</label>
          </div>
        </div>

        <!-- タスク追加ボタン -->
        <div class="mb-4">
          <a href="task/create.php" class="bg-green-500 text-white p-2 rounded inline-block">タスクを追加</a>
        </div>

        <!-- タスク一覧 -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="text-left py-2 px-4">タスク名</th>
                    <th class="text-left py-2 px-4">締切</th>
                    <th class="text-left py-2 px-4">カテゴリ名</th>
                    <th class="text-left py-2 px-4">完了/未完了</th>
                    <th class="text-left py-2 px-4">編集</th>
                    <th class="text-left py-2 px-4">削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['contents']); ?></td>
                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['deadline']); ?></td>
                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['category']); ?></td>
                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['status']); ?></td>
                    <td class="py-2 px-4">
                        <button class="bg-yellow-400 text-white p-1 rounded">編集</button>
                    </td>
                    <td class="py-2 px-4">
                        <button class="bg-red-500 text-white p-1 rounded">削除</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>