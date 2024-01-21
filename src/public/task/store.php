<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\PostRepository;
use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\ValueObject\Category\CategoryId;
use App\Domain\Port\IPostCommand;
use App\Infrastructure\Dao\PostDao;

session_start();

$user_id = $_SESSION['user']['id'] ?? null;

// ログインチェック
if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
header('Location: /create.php');
exit;
}

$contents = filter_input(INPUT_POST, 'contents');
$deadline = filter_input(INPUT_POST, 'deadline');
$category_id_value = filter_input(INPUT_POST, 'category_id');

// バリデーション
if (empty($contents) || empty($deadline)) {
$_SESSION['error'] = "内容または期限が入力されていません";
header('Location: /create.php');
exit;
}

// 登録処理
try {
$contents = new Contents($contents);
$deadline = new Deadline($deadline);
$category_id = new CategoryId($category_id_value);
$createTaskInput = new CreatePostInput($contents, $deadline, $user_id, $category_id);
$postDao = new PostDao();
$postRepository = new PostRepository($postDao);
$createTaskInteractor = new CreatePostInteractor($postRepository, $createTaskInput);
$createTaskOutput = $createTaskInteractor->handle();

if (!$createTaskOutput->isSuccess()) {
    throw new \Exception($createTaskOutput->message());
}

$_SESSION['message'] = $createTaskOutput->message();
Redirect::handler('/index.php');
} catch (\Exception $e) {
$_SESSION['error'] = $e->getMessage();
header('Location: /create.php');
exit;
}
?>