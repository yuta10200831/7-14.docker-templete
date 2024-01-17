<?php

namespace App\Domain\ValueObject\User;
use Exception;

final class UserName
{
    private $value;

    public function __construct(string $value)
    {
        if (mb_strlen($value) > 20) {
            throw new Exception('ユーザー名は20文字以下でお願いします！');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
?>