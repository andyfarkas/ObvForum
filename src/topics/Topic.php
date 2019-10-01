<?php

namespace ObvForum\Topics;

class Topic
{
    private $title;
    private $text;
    private $createdAt;
    private $createdBy;
    
    public function __construct(string $title, string $text, \DateTime $createdAt, \ObvForum\Users\User $createdBy)
    {
        $this->title = $title;
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
    }
    
    public function getTitle() : string
    {
        return $this->title;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function getCreatedBy() : \ObvForum\Users\User
    {
        return $this->createdBy;
    }

}