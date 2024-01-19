<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\InputPassword;

class SignInInput
{
    private $email;
    private $password;

    public function __construct(Email $email, InputPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function password(): InputPassword
    {
        return $this->password;
    }
}
?>
