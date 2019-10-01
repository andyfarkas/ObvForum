<?php

namespace ObvForum\Topics\Messages;

class MessagesStorage
{
    private $data = [];
    
    public function store(Message $message)    
    {
        $this->data[] = $message;
    }
    
    public function getAllForTopic(\ObvForum\Topics\Topic $topic) : array
    {
        $result = array_filter($this->data, function(Message $message) use($topic) {
            return $message->getTopic() == $topic;
        });
        
        usort($result, function(Message $a, Message $b) {
            return $a->getCreatedAt()->diff($b->getCreatedAt())->invert == 0 ? -1 : 1;
        });
        
        return $result;
    }
}