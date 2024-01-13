<?php

namespace App\UseCase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\Domain\Entity\User;
use App\Domain\Port\IUserCommand;
use App\Domain\Port\IUserQuery;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseOutput\SignUpOutput;

final class SignupInteractor {
    private $userCommand;
    private $userQuery;
    private $input;

    public function __construct(SignUpInput $input, IUserCommand $userCommand, IUserQuery $userQuery) {
        $this->input = $input;
        $this->userCommand = $userCommand;
        $this->userQuery = $userQuery;
    }


    public function handle(): SignUpOutput {
        $user = $this->userQuery->findUserByEmail($this->input->getEmail());
        if ($user) {
            return new SignUpOutput(false, "メールアドレスは既に使用されています");
        }

        $user = new User(
            $this->input->getName(),
            $this->input->getEmail(),
            $this->input->getPassword()
        );
        $this->userCommand->save($user);

        return new SignUpOutput(true, "ユーザー登録が完了しました！");
    }
}
?>