<?php

namespace App\Domain\ValueObject\Post;

class Contents {
    private $text;
    private $isValid;

    public function __construct($text) {
        $this->isValid = !empty($text);
        $this->text = $this->isValid ? $text : null;
    }

    public function getValue() {
        return $this->text;
    }

    public function isValid() {
        return $this->isValid;
    }
}
?>