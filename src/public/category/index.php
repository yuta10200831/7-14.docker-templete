<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\CategoryDao;
use App\Adapter\QueryService\CategoryQueryService;
use App\UseCase\UseCaseInteractor\CategoryReadInteractor;
use App\UseCase\UseCaseInput\CategoryReadInput;
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\UserId;

// ログインチェック
if (!isset($_SESSION['user']['name'])) {
  Redirect::to('user/signin.php');
  exit;
}

// ユーザーIDの存在と正当性のチェック
$userIdValue = $_SESSION['user']['id'] ?? null;
if ($userIdValue === null || !is_numeric($userIdValue) || $userIdValue < 1) {
  Redirect::to('create.php');
  exit;
}

try {
  $userId = new UserId((int)$_SESSION['user']['id']);
  $input = new CategoryReadInput($userId);
  $categoryDao = new CategoryDao();
  $categoryQueryService = new CategoryQueryService($categoryDao);
  $categoryReadInteractor = new CategoryReadInteractor($input, $categoryQueryService);
  $output = $categoryReadInteractor->handle();
  $categories = $output->getCategories();

} catch (Exception $e) {
  $_SESSION['errors'][] = $e->getMessage();
  Redirect::to('error.php');
  exit;
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
      <?php foreach ($categories as $data): ?>
      <?php $category = $data['category']; ?>
      <?php $isInUse = $data['isInUse']; ?>
      <li class="py-2 flex justify-between items-center">
        <span><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></span>
        <div>
          <?php if (!$isInUse): ?>
          <!-- 編集ボタン -->
          <a href="/category/edit.php?id=<?php echo $category['id']; ?>"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
            編集
          </a>
          <!-- 削除ボタン -->
          <a href="/category/delete.php?id=<?php echo $category['id']; ?>"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
            削除
          </a>
          <?php else: ?>
          <!-- 使用中の文言を赤文字で表示 -->
          <span class="text-red-500">使用中</span>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
    <a href="/index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
      戻る
    </a>
  </div>

</body>

</html>