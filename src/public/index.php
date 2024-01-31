<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Dao\TaskDao;
use App\Adapter\QueryService\TaskQueryService;
use App\UseCase\UseCaseInteractor\TaskInteractor;
use App\UseCase\UseCaseInput\TaskInput;
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\SearchKeyword;
use App\Domain\Entity\Post;
use App\Infrastructure\Dao\CategoryDao;

// ログインチェック
if (!isset($_SESSION['user']['name'])) {
    header('Location: login.php');
    exit;
}

// ユーザーIDのチェック
if (!isset($_SESSION['user']['id'])) {
    header('Location: create.php');
    exit;
}

try {
    $search = $_GET['search'] ?? '';
    $deadline = $_GET['deadline'] ?? '2020-01-01';
    $categoryId = $_GET['category_id'] ?? 1;

    $taskDao = new TaskDao();
    $taskQueryService = new TaskQueryService($taskDao);
    $taskInput = new TaskInput(
        new SearchKeyword($search),
        new Deadline($deadline),
        new CategoryId($categoryId)
    );
    $taskInteractor = new TaskInteractor($taskInput, $taskQueryService);
    $taskOutput = $taskInteractor->handle();
    $tasks = $taskOutput->getTasks();

    $categoryDao = new CategoryDao();
    $categories = $categoryDao->findAll();
    $categoryMap = [];
    foreach ($categories as $category) {
        $categoryMap[$category['id']] = $category['name'];
    }

} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('error.php');
    exit;
}
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
        <a href="category/index.php" class="mx-2 text-blue-500 hover:text-blue-700">カテゴリ一覧</a>
        <?php if (isset($_SESSION['user']['name'])): ?>
        <a href="user/logout.php" class="mx-2 text-blue-500 hover:text-blue-700">ログアウト</a>
        <?php else: ?>
        <a href="user/signin.php" class="mx-2 text-blue-500 hover:text-blue-700">ログイン</a>
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
          <?php
                foreach ($categories as $category): ?>
          <option value="<?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
          </option>
          <?php endforeach; ?>
        </select>

        <!-- 完了未完了 -->
        <div>
          <input type="radio" id="complete" name="status" value="complete" class="form-radio">
          <label for="complete" class="mr-2">完了</label>
          <br>
          <input type="radio" id="incomplete" name="status" value="incomplete" class="form-radio">
          <label for="incomplete">未完了</label>
        </div>
      </form>
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
          <td class="py-2 px-4"><?php echo htmlspecialchars($task->getContents()); ?></td>
          <td class="py-2 px-4"><?php echo htmlspecialchars($task->getDeadline()->format('Y-m-d H:i:s')); ?></td>
          <td class="py-2 px-4">
            <?php
            $categoryId = $task->getCategoryId();
            echo array_key_exists($categoryId, $categoryMap) ? htmlspecialchars($categoryMap[$categoryId]) : '不明なカテゴリ';
            ?>
          </td>
          <td class="py-2 px-4">
            <a href="task/updateStatus.php?id=<?php echo $task->getId(); ?>&status=<?php echo $task->getStatus(); ?>"
              class="bg-blue-500 text-white p-1 rounded">
              <?php echo $task->getStatus() == 0 ? '未完了' : '完了'; ?>
            </a>
          </td>
          <td class="py-2 px-4">
            <a href="task/edit.php?id=<?php echo $task->getId(); ?>" class="bg-yellow-400 text-white p-1 rounded">編集</a>
          </td>
          <td class="py-2 px-4">
            <a href="task/delete.php?id=<?php echo $task->getId(); ?>" class="bg-red-500 text-white p-1 rounded">削除</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>