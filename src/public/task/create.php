<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>新規タスク追加</title>
</head>

<body class="bg-gray-100 h-screen flex justify-center items-center">
  <div class="bg-white p-8 rounded-lg shadow-md w-1/2">
      <h2 class="text-2xl mb-4">新規投稿</h2>
      <form action="store.php" method="post">
          <?php if (!empty($_GET['error'])): ?>
              <p class="text-red-500 mb-2"><?php echo urldecode($_GET['error']); ?></p>
          <?php endif; ?>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">カテゴリを選んで下さい</label>
            <select name="category_id" class="border p-2 rounded w-full">
            <?php
            // データベース接続
            $pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

            // カテゴリ一覧を取得
            $stmt = $pdo->query("SELECT * FROM categories");
            $categories = $stmt->fetchAll();

            foreach ($categories as $category): ?>
            <option value="<?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
            <?php endforeach; ?>
            </select>
        </div>

          <div class="mb-4">
              <label class="block text-sm font-bold mb-2">タスクを追加</label>
              <textarea name="contents" class="border p-2 rounded w-full h-24"></textarea>
          </div>

          <div class="mb-4">
              <input type="date" name="deadline" class="border p-2 rounded w-full">
          </div>

          <input type="submit" value="追加" class="bg-blue-500 text-white p-2 rounded w-full">
      </form>
      <a href="/index.php" class="block text-center mt-4 bg-green-500 text-white p-2 rounded">戻る</a>
  </div>

</body>
</html>
