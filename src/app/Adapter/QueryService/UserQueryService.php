<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\HashedPassword;
use App\Domain\Port\IUserQuery;

class UserQueryService implements IUserQuery {
    private $userDao;

    public function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }

    public function findUserByEmail(Email $email): ?User {
        $userMapper = $this->userDao->findUserByEmail($email);
        if (!$userMapper) {
            return null;
        }

        $hashedPassword = new HashedPassword($userMapper['password']);
        $user = new User(
            new UserId($userMapper['id']),
            new UserName($userMapper['name']),
            $email,
            $hashedPassword
        );

        return $user;
    }
}
?>