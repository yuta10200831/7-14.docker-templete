<?php
namespace App\UseCase\UseCaseInput;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;

class SignupInput {
    private $name;
    private $email;
    private $password;

    public function __construct(
        UserName $name,
        Email $email,
        Password $password
    ) {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPasswordConfirm() {
        return $this->passwordConfirm;
    }
}
?>