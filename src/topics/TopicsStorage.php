<?php

namespace ObvForum\Topics;

class TopicsStorage
{
    private $data = [];
    
    public function store(Topic $topic)
    {
        $this->data[] = $topic;
    }
    
    /**
     * 
     * @return Topic[]
     */
    public function list() : array
    {
        return $this->data;
    }
}
