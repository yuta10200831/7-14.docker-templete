<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseInteractor\SignInInteractor;
use App\Domain\Port\IUserQuery;
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

    $query = new UserQueryService();
    $useCase = new SignInInteractor($useCaseInput, $queryService);

    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }

    Redirect::handler('../index.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('./signin.php');
}
?>