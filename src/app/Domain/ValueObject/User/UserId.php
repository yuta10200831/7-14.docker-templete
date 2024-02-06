<?php
namespace App\Domain\ValueObject\User;

final class UserId
{
    const MIN_VALUE = 1;

    private $value;

    public function __construct(int $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception('不正な値です');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function isInvalid(int $value): bool
    {
        return $value < self::MIN_VALUE;
    }
}