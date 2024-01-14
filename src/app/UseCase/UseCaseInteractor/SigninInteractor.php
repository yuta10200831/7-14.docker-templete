<?php
namespace App\UseCase\UseCaseInteractor;

use App\Infrastructure\Dao\UserDao;
use App\Adapter\QueryService\UserQueryService;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseOutput\SignInOutput;

final class SignInInteractor {
    private $userQueryService;
    private $input;

    public function __construct(SignInInput $input, UserQueryService $userQueryService) {
        $this->input = $input;
        $this->userQueryService = $userQueryService;
    }

    public function handle(): SignInOutput {
        $email = $this->input->getEmail();
        $inputPassword = $this->input->getPassword();

        $user = $this->userQueryService->findUserByEmail($email);
        if ($user === null) {
            return new SignInOutput(false, 'ユーザーが見つかりません');
        }

        if (!password_verify($inputPassword, $user->getPassword()->getHashedValue())) {
            return new SignInOutput(false, 'パスワードが一致しません');
        }

        $this->saveSession($user);
        return new SignInOutput(true, 'ログインしました');
    }

    private function saveSession($user): void {
        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['name'] = $user->getName();
    }
}
?>