<?php

class ForumTopicsTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateTopic_validData_returnsCreatedTopic()
    {
        $app = new \ObvForum\ObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category);
        $this->assertInstanceOf(\ObvForum\Topics\Topic::class, $topic);
    }

    public function testCreateTopic_nonExistingCategory_throwsCategoryNotFoundException()
    {
        $app = new \ObvForum\ObvForum();
        $category = new \ObvForum\Categories\Category("some id", "This category does not exist");

        $this->expectException(\ObvForum\Categories\CategoryNotFoundException::class);
        $app->createTopic("A new topic", "Some description", $category);
    }

    public function testFindTopicById_existingTopic_returnsThatTopic()
    {
        $app = new \ObvForum\ObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category);
        $retrievedTopic = $app->findTopicById($topic->getId());
        $this->assertEquals($topic, $retrievedTopic);
    }

    public function testFindTopicById_nonExistingTopicId_throwsTopicNotFoundException()
    {
        $app = new \ObvForum\ObvForum();
        $this->expectException(\ObvForum\Topics\TopicNotFoundException::class);
        $app->findTopicById("this id does not exist");
    }
}