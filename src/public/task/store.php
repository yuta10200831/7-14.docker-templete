<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\PostRepository;
use App\UseCase\UseCaseInput\CreateTaskInput;
use App\UseCase\UseCaseInteractor\CreateTaskInteractor;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Deadline;
use App\Domain\Port\IPostCommand;

session_start();

$user_id = $_SESSION['user']['id'] ?? null;

// ログインチェック
if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "
POST") {
header('Location: /create.php');
exit;
}

$contents = filter_input(INPUT_POST, 'contents');
$deadline = filter_input(INPUT_POST, 'deadline');

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
$createTaskInput = new CreateTaskInput($contents, $deadline, $user_id);
$postRepository = new PostRepository();
$createTaskInteractor = new CreateTaskInteractor($postRepository, $createTaskInput);
$createTaskOutput = $createTaskInteractor->handle();

if (!$createTaskOutput->isSuccess()) {
    throw new \Exception($createTaskOutput->getMessage());
}

$_SESSION['message'] = $createTaskOutput->getMessage();
Redirect::handler('/index.php');
} catch (\Exception $e) {
$_SESSION['error'] = $e->getMessage();
header('Location: /create.php');
exit;
}
?>