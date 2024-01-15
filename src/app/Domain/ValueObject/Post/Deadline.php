<?php
namespace Domain\ValueObject\Post;

class Deadline {
    private $date;

    public function __construct($date) {
        if (!$this->isValidDeadline($date)) {
            throw new InvalidArgumentException("過去の日程では登録出来ません");
        }
        $this->date = $date;
    }

    private function isValidDeadline($date) {
        return (new DateTime($date)) > new DateTime();
    }

    public function getDate() {
        return $this->date;
    }
}
?>