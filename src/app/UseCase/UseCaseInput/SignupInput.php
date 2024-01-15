<?php
namespace App\UseCase\UseCaseInput;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\InputPassword;

class SignupInput {
    private $name;
    private $email;
    private $password;

    public function __construct(
        UserName $name,
        Email $email,
        InputPassword $password
    ) {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): InputPassword
    {
        return $this->password;
    }
}
?>