<?php
namespace App\Domain\ValueObject\User;
use Exception;

class Password {
    private $hashedValue;

    public function __construct(string $value) {
        $this->validate($value); // バリデーションメソッドを呼び出し
        $this->hashedValue = password_hash($value, PASSWORD_BCRYPT);
    }

    private function validate(string $value): void {
        if (!$this->containsUppercase($value)) {
            throw new Exception("パスワードには少なくとも1つの大文字が必要です。");
        }

        if (!$this->containsLowercase($value)) {
            throw new Exception("パスワードには少なくとも1つの小文字が必要です。");
        }

        if (!$this->containsDigit($value)) {
            throw new Exception("パスワードには少なくとも1つの数字が必要です。");
        }
    }

    private function containsUppercase(string $value): bool {
        return preg_match('/[A-Z]/', $value) === 1;
    }

    private function containsLowercase(string $value): bool {
        return preg_match('/[a-z]/', $value) === 1;
    }

    private function containsDigit(string $value): bool {
        return preg_match('/\d/', $value) === 1;
    }

    public function getHashedValue(): string {
        return $this->hashedValue;
    }
}
?>