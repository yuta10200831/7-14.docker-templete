<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\InputPassword;
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
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
    $_SESSION['error_message'] = '必要な情報をすべて入力してください。';
    Redirect::handler('signup.php');
    exit;
}

try {
    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);

    if ($password !== $confirmPassword) {
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