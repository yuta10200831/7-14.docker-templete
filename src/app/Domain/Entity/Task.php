<?php

namespace App\Domain\Entity;

class Task
{
    private $id;
    private $contents;
    private $deadline;
    private $status;
    private $categoryId;

    public function __construct($id, $contents, $deadline, $status, $categoryId)
    {
        $this->id = $id;
        $this->contents = $contents;
        $this->deadline = $deadline;
        $this->status = $status;
        $this->categoryId = $categoryId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function markAsComplete()
    {
        $this->status = 1;
    }

    public function markAsIncomplete()
    {
        $this->status = 0;
    }
}
?>