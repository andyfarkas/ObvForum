<?php

namespace ObvForum\Topics\Messages;

class Message
{
    private $text;
    private $createdAt;
    private $createdBy;
    private $topic;

    public function __construct(
            string $text, 
            \DateTime $createdAt, 
            \ObvForum\Users\User $createdBy,
            \ObvForum\Topics\Topic $topic
    )
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
        $this->topic = $topic;
    }
    
    public function getTopic() : \ObvForum\Topics\Topic
    {
        return $this->topic;
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

