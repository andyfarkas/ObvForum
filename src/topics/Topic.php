<?php

namespace ObvForum\Topics;

class Topic
{
    private $id;
    private $title;
    private $text;
    private $createdAt;
    private $createdBy;
    private $category;
    
    public function __construct(
        string $id,
        string $title,
        string $text,
        \DateTime $createdAt,
        string $createdBy,
        string $category
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
        $this->category = $category;
    }

    public function getId() : string
    {
        return $this->id;
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

    public function getCreatedBy() : string
    {
        return $this->createdBy;
    }

    public function getCategory() : string
    {
        return $this->category;
    }
}