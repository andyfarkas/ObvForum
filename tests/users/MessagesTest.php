<?php

class MessagesTest extends \PHPUnit\Framework\TestCase
{
    public function testRetrieveMessagesForTopicInChronologicalOrder()
    {
        $storage = new ObvForum\Topics\Messages\MessagesStorage();
        $createdBy = new ObvForum\Users\User('alice', 'a', 'p');
        
        $topic = new \ObvForum\Topics\Topic('A topic', 'empty message', new DateTime(), $createdBy);
        $anotherTopic = new \ObvForum\Topics\Topic('Another topic', 'empty message', new DateTime(), $createdBy);
        
        $firstMessage = new \ObvForum\Topics\Messages\Message(
                "First message", 
                DateTime::createFromFormat('dmY', '01012000'), 
                $createdBy,
                $topic
        );        
        
        $secondMessage = new \ObvForum\Topics\Messages\Message(
                "Second message", 
                DateTime::createFromFormat('dmY', '02012000'), 
                $createdBy,
                $anotherTopic
        );        
        
        $thirdMessage = new \ObvForum\Topics\Messages\Message(
                "Third message", 
                DateTime::createFromFormat('dmY', '03012000'), 
                $createdBy,
                $topic
        );        
        
        $storage->store($thirdMessage);
        $storage->store($secondMessage);
        $storage->store($firstMessage);
        
        $allForTopic = $storage->getAllForTopic($topic);
        $this->assertEquals([$firstMessage, $thirdMessage], $allForTopic);
    }
}