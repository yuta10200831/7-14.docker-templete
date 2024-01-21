<?php

namespace App\Domain\ValueObject\Category;

class CategoryName {
    private $value;

    public function __construct(string $value) {
        $this->ensureIsValidName($value);
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    private function ensureIsValidName(string $value): void {
        if (empty($value)) {
            throw new \InvalidArgumentException('Category name cannot be empty.');
        }
    }
}
?>