<?php
namespace App\Domain\ValueObject\User;

use Exception;

class Password {
    private $hashedValue;

    public function __construct(string $value) {
        $this->hashedValue = password_hash($value, PASSWORD_BCRYPT);
    }

    public function getHashedValue(): string {
        return $this->hashedValue;
    }

    public function verify(string $inputPassword): bool {
        return password_verify($inputPassword, $this->hashedValue);
    }
}
?>