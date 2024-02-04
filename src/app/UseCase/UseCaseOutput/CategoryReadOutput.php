<?php
namespace App\UseCase\UseCaseOutput;

use App\Domain\Entity\Category;

final class CategoryReadOutput
{
    private $isSuccess;
    private $categories;
    private $message;

    public function __construct(bool $isSuccess, array $categories, string $message = '')
    {
        $this->isSuccess = $isSuccess;
        $this->categories = $categories;
        $this->message = $message;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCategoriesWithUsage(): array {
        return $this->categories;
    }
}