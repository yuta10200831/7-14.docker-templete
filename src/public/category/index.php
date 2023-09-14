<?php
// データベース接続
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

// エラーメッセージの取得
if (isset($_GET['error'])) {
  $error_messages = explode(', ', urldecode($_GET['error']));
}

// カテゴリ一覧取得
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// カテゴリがタスクで使われているかチェック
$category_usage = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE category_id = :category_id");
    $stmt->bindParam(':category_id', $category['id'], PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $category_usage[$category['id']] = $count > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>カテゴリ一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center pt-20">

  <div class="bg-white rounded-lg shadow-lg w-1/3 p-8">
    <h1 class="text-3xl mb-4 text-center">カテゴリ一覧</h1>

    <?php if (!empty($error_messages)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul>
          <?php foreach ($error_messages as $error): ?>
            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="/category/store.php" method="post" class="mb-4 flex">
      <input type="text" name="name" placeholder="カテゴリー追加" class="px-4 py-2 border rounded flex-grow">
      <input type="submit" value="登録" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
    </form>

    <ul class="divide-y divide-gray-200">
      <?php foreach ($categories as $category): ?>
        <li class="py-2 flex justify-between items-center">
          <span><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></span>
          <div>
            <!-- 編集ボタン -->
            <a href="/category/edit.php?id=<?php echo $category['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
              編集
            </a>

            <?php if (!$category_usage[$category['id']]): ?>
              <!-- 削除ボタン -->
              <a href="/category/delete.php?id=<?php echo $category['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                削除
              </a>
            <?php else: ?>
              <span class="text-red-500">現在タスクで使用されているので削除できません</span>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</body>
</html>
