<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Password;
use App\Domain\Entity\User;
use App\Domain\Port\IUserQuery;

class UserQueryService implements IUserQuery {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function findUserByEmail(Email $email): ?User {
        $userMapper = $this->userDao->findUserByEmail($email);
        if (!$userMapper) {
            return null;
        }

        return new User(
            new UserName($userMapper['name']),
            $email,
            new Password($userMapper['password'])
        );
    }
}
?>