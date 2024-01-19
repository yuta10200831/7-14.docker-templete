<?php
namespace App\Adapter\Repository;
use App\Domain\Entity\User;
use App\Domain\Port\IUserCommand;
use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\User\NewUser;

class UserRepository implements IUserCommand {
    private $userDao;

    public function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }

    public function save(User $user): void {
        $userName = $user->getName()->value();
        $userEmail = $user->getEmail()->value();

        $userPasswordHash = $user->password()->value();

        $this->userDao->createUser($userName, $userEmail, $userPasswordHash);
    }
}
?>