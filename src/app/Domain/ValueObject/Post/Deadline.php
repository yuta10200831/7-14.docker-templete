<?php
namespace App\Domain\ValueObject\Post;

use Exception;

class Deadline {
    private $date;

    public function __construct($date) {
        $this->date = new \DateTime($date);
    }

    public function format($format) {
        return $this->date->format($format);
    }

    public function getValue() {
        return $this->date->format('Y-m-d H:i:s');
    }
}
?>