<?php

class TopicsTest extends \PHPUnit\Framework\TestCase
{
    public function testStoreTopicsAndGetListOfTopics()
    {
        $storage = new ObvForum\Topics\TopicsStorage();
        $topic = new \ObvForum\Topics\Topic(
                "hello world topic",
                'hello hello hello hello hello',
                new DateTime(),
                new ObvForum\Users\User('alice', 'a', 'p')
        );
        $storage->store($topic);
        $storage->store($topic);
        
        $list = $storage->list();
        $this->assertCount(2, $list);
    }
}
