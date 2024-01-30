<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\CategoryRepository;
use App\UseCase\UseCaseInput\CreateCategoryInput;
use App\UseCase\UseCaseInteractor\CreateCategoryInteractor;
use App\Domain\ValueObject\Category\CategoryName;
use App\Infrastructure\Dao\CategoryDao;
use App\Domain\ValueObject\User\UserId;
use App\UseCase\UseCaseOutput\CreateCategoryOutput;

session_start();

$user_id = $_SESSION['user']['id'] ?? null;

if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
    exit;
}

$name = filter_input(INPUT_POST, 'name');

if (empty($name)) {
    $_SESSION['error'] = "カテゴリ名が入力されていません";
    header('Location: /category/create.php');
    exit;
}

try {
    $categoryName = new CategoryName($name);
    $userId = new UserId($user_id);
    $categoryInput = new CreateCategoryInput($categoryName, $userId);
    $categoryDao = new CategoryDao();
    $categoryRepository = new CategoryRepository($categoryDao);
    $createCategoryInteractor = new CreateCategoryInteractor($categoryRepository, $categoryInput);
    $createCategoryOutput = $createCategoryInteractor->handle();

    if ($createCategoryOutput->isSuccess()) {
        $_SESSION['message'] = $createCategoryOutput->message();
        header('Location: /category/index.php');
        exit;
    } else {
        $_SESSION['error'] = $createCategoryOutput->message();
        header('Location: /category/create.php');
        exit;
    }
} catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /category/create.php');
    exit;
}
?>