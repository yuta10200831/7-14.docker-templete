<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\HashedPassword;

class User {
    private $name;
    private $email;
    private $password;

    public function __construct(UserName $name, Email $email, HashedPassword $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): UserName {
        return $this->name;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }
}
?>