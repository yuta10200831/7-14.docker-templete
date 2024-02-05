<?php
namespace App\UseCase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\InputPassword;
use App\Domain\Entity\User;
use App\Domain\Port\IUserCommand;
use App\Domain\Port\IUserQuery;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseOutput\SignUpOutput;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\NewUser;

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
        $existingUser = $this->userQuery->findUserByEmail($this->input->email());
        if ($existingUser) {
            return new SignUpOutput(false, "メールアドレスは既に使用されています");
        }

        return $this->signup();
    }

    private function signup(): SignUpOutput {
        $newUser = new NewUser(
            $this->input->name(),
            $this->input->email(),
            $this->input->password()
        );

        $this->userCommand->save($newUser);

        return new SignUpOutput(true, "ユーザー登録が完了しました！");
    }
}