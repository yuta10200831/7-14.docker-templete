<?php

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST['title'] ?? '';
  $contents = $_POST['contents'] ?? '';
  $category_id = $_POST['category_id'] ?? null;

  if (empty($title) || empty($contents)) {
      $error_message = "タイトルか内容の入力がありません";
      return;
  }

  $pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');
  $stmt = $pdo->prepare("INSERT INTO tasks (title, contents, category_id) VALUES (?, ?, ?)");

  $stmt->execute([$title, $contents, $category_id]);

  header("Location: /index.php");
  exit;
}

?>

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
      <form action="create.php" method="post">
          <?php if ($error_message): ?>
              <p class="text-red-500 mb-2"><?php echo $error_message; ?></p>
          <?php endif; ?>

          <div class="mb-4">
              <label class="block text-sm font-bold mb-2">カテゴリを選んで下さい</label>
              <select name="category_id" class="border p-2 rounded w-full">
                  <!-- ここにPHPでカテゴリを動的に生成 -->
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
