<?php

namespace App\Domain\ValueObject\Post;

use Exception;

class Contents {
    private $value;
    private $isValid;

    public function __construct(string $value) {
        if (!$this->isValid($value)) {
            throw new Exception('空の文字列では扱えません');
        }
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    private function isValid(string $value): bool {
        return !empty($value);
    }
}
?>