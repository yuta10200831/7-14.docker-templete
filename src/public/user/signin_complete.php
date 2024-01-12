<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseInteractor\SignInInteractor;
use App\Infrastructure\Dao\UserDao;
use App\Adapter\QueryService\UserQueryService;

session_start();

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

try {
    if (empty($email) || empty($password)) {
        throw new Exception('パスワードとメールアドレスを入力してください');
    }

    $userEmail = new Email($email);
    $inputPassword = new Password($password);
    $useCaseInput = new SignInInput($userEmail, $inputPassword);

    $userDao = new UserDao();
    $queryService = new UserQueryService($userDao);

    $interactor = new SignInInteractor($useCaseInput, $queryService);
    $output = $interactor->handle();

    if (!$output->isSuccess()) {
        throw new Exception($output->message());
    }

    Redirect::handler('../index.php');
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: signin.php');
    exit;
}
?>