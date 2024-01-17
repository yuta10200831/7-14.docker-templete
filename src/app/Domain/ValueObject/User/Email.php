<?php

namespace App\Domain\ValueObject\User;
use Exception;

final class Email
{
    private $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('無効なメールアドレスです。');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
?>