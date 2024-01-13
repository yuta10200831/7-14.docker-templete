<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseInteractor\SignupInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\UserRepository;
use App\Adapter\QueryService\UserQueryService;
use App\Domain\Port\IUserCommand;
use App\Domain\Port\IUserQuery;
use App\Infrastructure\Dao\UserDao;

session_start();

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$passwordConfirm = filter_input(INPUT_POST, 'password_confirm');

// ガード節を使用して入力が不正な場合にリダイレクト
if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm)) {
    $_SESSION['error_message'] = '必要な情報をすべて入力してください。';
    Redirect::handler('signup.php');
    exit;
}

try {
    // ガード節内で各バリデーションルールをチェックし、エラーメッセージを生成
    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new Password($password);

    if (mb_strlen($name) > 20) {
        $_SESSION['error_message'] = 'ユーザー名は20文字以下でお願いします！';
        Redirect::handler('signup.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = '無効なメールアドレスです。';
        Redirect::handler('signup.php');
        exit;
    }

    if ($password !== $passwordConfirm) {
        $_SESSION['error_message'] = 'パスワードが一致しません。';
        Redirect::handler('signup.php');
        exit;
    }

    // ユーザー登録機能
    $input = new SignupInput($userName, $userEmail, $userPassword);
    $userDao = new UserDao();
    $repository = new UserRepository($userDao);
    $queryService = new UserQueryService($userDao);
    $signupInteractor = new SignupInteractor($input, $repository, $queryService);
    $output = $signupInteractor->handle();

    if (!$output->isSuccess()) {
        $_SESSION['error_message'] = $output->getMessage();
        Redirect::handler('signup.php');
        exit;
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('signin.php');
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    Redirect::handler('signup.php');
    exit;
}
?>