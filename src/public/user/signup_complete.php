<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseInteractor\SignUpInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\UserRepository;
use App\Adapter\QueryService\UserQueryService;
use App\Domain\Port\IUserCommand;
use App\Domain\Port\IUserQuery;

session_start();

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

try {
    if (empty($name) || empty($email) || empty($password)) {
        throw new Exception('必要な情報をすべて入力してください。');
    }

    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new Password($password);

    $input = new SignupInput($userName, $userEmail, $userPassword, $userPasswordConfirm);
    $repository = new UserRepository();
    $Query = new UserQueryService();
    $signupInteractor = new SignupInteractor($input, $repository, $Query);
    $output = $signupInteractor->handle();

    if (!$output->isSuccess()) {
        throw new Exception($output->getMessage());
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('signin.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['password'] = $password;
    Redirect::handler('signup.php');
}
?>