<?php
namespace Domain\ValueObject\Post;

class Contents {
    private $text;

    public function __construct($text) {
        if (empty($text)) {
            throw new InvalidArgumentException("タスクが空では登録出来ません");
        }
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }
}
?>