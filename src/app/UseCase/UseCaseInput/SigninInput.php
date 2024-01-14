<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\Email;

class SignInInput
{
    private $email;
    private $password;

    public function __construct(Email $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
?>