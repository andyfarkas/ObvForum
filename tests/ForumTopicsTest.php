<?php

use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\ObvForum;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicNotFoundException;
use PHPUnit\Framework\TestCase;

class ForumTopicsTest extends TestCase
{
    public function testCreateTopic_validData_returnsCreatedTopic()
    {
        $app = new ObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category);
        $this->assertInstanceOf(Topic::class, $topic);
    }

    public function testCreateTopic_nonExistingCategory_throwsCategoryNotFoundException()
    {
        $app = new ObvForum();
        $category = new Category("some id", "This category does not exist");

        $this->expectException(CategoryNotFoundException::class);
        $app->createTopic("A new topic", "Some description", $category);
    }

    public function testFindTopicById_existingTopic_returnsThatTopic()
    {
        $app = new ObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category);
        $retrievedTopic = $app->findTopicById($topic->getId());
        $this->assertEquals($topic, $retrievedTopic);
    }

    public function testFindTopicById_nonExistingTopicId_throwsTopicNotFoundException()
    {
        $app = new ObvForum();
        $this->expectException(TopicNotFoundException::class);
        $app->findTopicById("this id does not exist");
    }
}