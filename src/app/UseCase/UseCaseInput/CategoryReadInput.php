<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\UserId;

class CategoryReadInput
{
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}