<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\User\NewUser;

interface IUserCommand {
    public function save(NewUser $newUser): void;
}