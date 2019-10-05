<?php

namespace Obv\ObvForum\Replies;

class Reply
{
    private $id;
    private $content;
    private $createdBy;
    private $createdAt;
    private $topic;

    public function __construct(string $id, string $content, string $createdBy, \DateTime $createdAt, string $topic)
    {
        $this->content = $content;
        $this->createdBy = $createdBy;
        $this->createdAt = $createdAt;
        $this->topic = $topic;
        $this->id = $id;
    }

    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

}
