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
<<<<<<< HEAD
        $userPasswordHash = $user->getPassword()->getHashedValue();
=======
        $userPasswordHash = $user->password()->value();

>>>>>>> feature/signup-DDD
        $this->userDao->createUser($userName, $userEmail, $userPasswordHash);
    }
}
?>