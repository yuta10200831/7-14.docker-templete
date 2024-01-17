<?php
namespace App\Domain\ValueObject\User;

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\InputPassword;

final class NewUser
{
    private $userName;
    private $email;
    private $password;

    public function __construct(
        UserName $userName,
        Email $email,
        InputPassword $password
    ) {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUserName(): UserName {
        return $this->userName;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getPassword(): InputPassword {
        return $this->password;
    }
}
?>