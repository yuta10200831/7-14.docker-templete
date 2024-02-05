<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\TaskDao;
use App\Adapter\QueryService\TaskQueryService;
use App\UseCase\UseCaseInteractor\TaskEditInteractor;
use App\UseCase\UseCaseInput\TaskEditInput;
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\ValueObject\SearchKeyword;
use App\Domain\Entity\Post;
use App\Infrastructure\Dao\CategoryDao;

// ログインチェック
if (!isset($_SESSION['user']['name'])) {
    header('Location: user/signin.php');
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
    $categoryId = $_GET['category_id'] ?? '';
    $status = $_GET['status'] ?? '';
    $order = $_GET['order'] ?? 'new';
    $id = $_GET['id'] ?? null;

    if ($id === null) {
        header('Location: /index.php?error=' . urlencode('IDが指定されていません'));
        exit;
    }

    $taskRepository = new TaskDao();
    $task = $taskRepository->findTaskById($id);

    if (!$task) {
        header('Location: /index.php?error=' . urlencode('指定されたタスクが存在しません'));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contents = $_GET['contents'] ?? '';
        $newDeadline = $_GET['deadline'] ?? '';
        $categoryId = $_GET['category_id'] ?? '';
        $status = isset($_GET['status']) ? 1 : 0;
        $taskEditInput = new TaskEditInput($id, $contents, $newDeadline, $categoryId, $status);
        $taskEditInteractor = new TaskEditInteractor($taskRepository, $taskEditInput);
        $taskEditOutput = $taskEditInteractor->handle();

        if ($taskEditOutput->isSuccess()) {
            header('Location: /index.php');
            exit;
        } else {
            $_SESSION['errors'][] = 'タスクの更新に失敗しました';
            Redirect::handler('error.php');
            exit;
        }
    }

    $categoryDao = new CategoryDao();
    $categories = $categoryDao->findAll();
    $categoryMap = [];
    foreach ($categories as $category) {
        $categoryMap[$category['id']] = $category['name'];
    }

    $formContents = $task->getContents();
    $formDeadline = date('Y-m-d', strtotime($task->getDeadline()));
    $formCategoryId = $task->getCategoryId();
    $formStatus = $task->getStatus();

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
  <title>タスク編集</title>
</head>

<body>
  <h1>タスク編集</h1>
  <?php if (!empty($errors)): ?>
  <div class="error">
    <?php foreach ($errors as $err): ?>
    <div><?= htmlspecialchars(urldecode($err)) ?></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?= $task->getId() ?>">
    <label>
      カテゴリ:
      <select name="category_id">
        <?php
        foreach ($categories as $category):
        ?>
        <option value="<?= $category['id'] ?>" <?= ($formCategoryId == $category['id'] ? 'selected' : '') ?>>
          <?= htmlspecialchars($category['name']) ?>
        </option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>
      タスク名:
      <input type="text" name="contents" value="<?= htmlspecialchars($formContents) ?>">
    </label>
    <label>
      締切:
      <input type="date" name="deadline" value="<?= htmlspecialchars($formDeadline) ?>">
    </label>
    <label>
      完了:
      <input type="checkbox" name="status" value="1" <?= ($formStatus == 1 ? 'checked' : '') ?>>
    </label>
    <button type="submit">更新</button>
  </form>
  <a href="/index.php">戻る</a>
</body>

</html>