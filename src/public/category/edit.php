<?php

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Dao\CategoryDao;

if (!isset($_SESSION['user']['name'])) {
    header('Location: user/signin.php');
    exit;
}

$categoryId = $_GET['id'] ?? null;
if ($categoryId === null) {
    header('Location: category/index.php');
    exit;
}

$categoryDao = new CategoryDao();
$category = $categoryDao->findById($categoryId);

if (!$category) {
    $_SESSION['errors'][] = '指定されたカテゴリが見つかりません。';
    header('Location: category/index.php');
    exit;
}

$errors = $_SESSION['errors'] ?? '';
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html>

<head>
  <title>カテゴリ編集</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex flex-col items-center pt-20">
  <div class="bg-white rounded-lg shadow-lg w-1/3 p-8">
    <h1 class="text-3xl mb-4 text-center">カテゴリ編集</h1>

    <!-- エラーメッセージがあれば表示 -->
    <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
    <p class="text-red-500"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endforeach; ?>
    <?php endif; ?>

    <form action="update.php" method="post" class="mb-4">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoryId, ENT_QUOTES, 'UTF-8'); ?>">
      <input type="text" name="name" placeholder="カテゴリー名"
        value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>"
        class="px-4 py-2 border rounded flex-grow">
      <input type="submit" value="更新" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
    </form>
    <a href="/category/index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
      戻る
    </a>
  </div>
</body>

</html>