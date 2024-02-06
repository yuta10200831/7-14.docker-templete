<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\Category\CategoryName;
use App\Domain\ValueObject\User\UserId;
use App\UseCase\UseCaseInput\CategoryEditInput;
use App\Infrastructure\Dao\CategoryDao;
use App\Adapter\Repository\CategoryRepository;
use App\UseCase\UseCaseInteractor\CategoryEditInteractor;

// ユーザー認証の確認
if (!isset($_SESSION['user']['name'])) {
    header('Location: user/signin.php');
    exit;
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$userIdValue = $_SESSION['user']['id'] ?? null;

if (is_null($userIdValue) || is_null($id) || empty($name)) {
    $_SESSION['errors'] = 'カテゴリ名を入力してください。';
    header("Location: edit.php?id=" . urlencode($id));
    exit;
}

try {
    $categoryName = new CategoryName($name);
    $userId = new UserId((int)$userIdValue);
    $input = new CategoryEditInput($categoryName, $userId, (int)$id);

    $categoryDao = new CategoryDao();
    $categoryRepository = new CategoryRepository($categoryDao);

    $categoryEditInteractor = new CategoryEditInteractor($input, $categoryRepository);
    $output = $categoryEditInteractor->handle();

    header('Location: index.php');
    exit;
} catch (Exception $e) {
    $_SESSION['errors'] = $e->getMessage();
    header("Location: edit.php?id=" . urlencode($id));
    exit;
}