<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryService\UserQueryService;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseOutput\SignInOutput;
use App\Domain\Port\IUserQuery;

final class SignInInteractor
{
    private $userQueryService;
    private $input;

    public function __construct(SignInInput $input, IUserQuery $queryService)
    {
        $this->userQueryService = $queryService;
        $this->input = $input;
    }

    public function handler(): SignInOutput
    {
        $user = $this->userQueryService->findByEmail($this->input->email());
        if ($user === null || !$user->getPassword()->verify($this->input->password()->value())) {
            return new SignInOutput(false, 'メールアドレスまたはパスワードが間違っています');
        }

        $this->saveSession($user);
        return new SignInOutput(true, 'ログインしました');
    }

    private function saveSession($user): void
    {
        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['name'] = $user->getName();
        $_SESSION['user']['memberStatus'] = $user->isPremiumMember() ? 'プレミアム会員' : 'ノーマル会員';
    }
}
?>