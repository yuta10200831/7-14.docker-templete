<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\User\Email;
use App\Domain\Entity\User;

interface IUserQuery {
    public function findUserByEmail(Email $email): ?User;
}
?>