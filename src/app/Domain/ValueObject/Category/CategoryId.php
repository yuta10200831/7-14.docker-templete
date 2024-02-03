<?php

namespace App\Domain\ValueObject\Category;

class CategoryId {
    private $value;
    private $isValid;

    public function __construct($value) {
        $this->isValid = is_numeric($value) && $value > 0;
        $this->value = $this->isValid ? $value : null;
    }

    public function getValue() {
        return $this->value;
    }

    public function isValid() {
        return $this->isValid;
    }
}