<?php
namespace App\Domain\Port;

use App\Domain\Entity\User;

interface IUserCommand {
    public function save(User $user): void;
}
?>