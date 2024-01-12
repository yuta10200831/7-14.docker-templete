<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;

class SignInInput
{
    private $email;
    private $password;

    public function __construct(Email $email, Password $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
?>