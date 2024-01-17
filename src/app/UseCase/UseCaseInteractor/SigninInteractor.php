<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryService\UserQueryService;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseOutput\SignInOutput;
use App\Domain\ValueObject\User\InputPassword;
use App\Domain\Entity\User;

final class SignInInteractor {
    private $userQueryService;
    private $input;

    public function __construct(SignInInput $input, UserQueryService $userQueryService) {
        $this->input = $input;
        $this->userQueryService = $userQueryService;
    }

    public function handle(): SignInOutput {
        $email = $this->input->getEmail();
        $inputPassword = $this->input->password()->value();

        $user = $this->userQueryService->findUserByEmail($email);

        if ($user === null) {
            return new SignInOutput(false, 'ユーザーが見つかりません');
        }

        $hashedPassword = $user->password();

        if (!$hashedPassword->verify(new InputPassword($inputPassword))) {
            return new SignInOutput(false, 'パスワードが一致しません');
        }

        $this->saveSession($user);
        return new SignInOutput(true, 'ログインしました');
    }

    private function saveSession(User $user): void {
        $_SESSION['user']['id'] = $user->getId()->value();
        $_SESSION['user']['name'] = $user->getName()->value();
    }
}
?>