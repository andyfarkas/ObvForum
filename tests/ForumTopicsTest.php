<?php

use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicNotFoundException;
use PHPUnit\Framework\TestCase;

class ForumTopicsTest extends TestCase
{
    public function testCreateTopic_validData_returnsCreatedTopic()
    {
        $app = ObvForumCreator::createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category->getId());
        $this->assertInstanceOf(Topic::class, $topic);
    }

    public function testCreateTopic_nonExistingCategory_throwsCategoryNotFoundException()
    {
        $app = ObvForumCreator::createObvForum();
        $category = new Category("some id", "This category does not exist");

        $this->expectException(CategoryNotFoundException::class);
        $app->createTopic("A new topic", "Some description", $category->getId());
    }

    public function testFindTopicById_existingTopic_returnsThatTopic()
    {
        $app = ObvForumCreator::createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category->getId());
        $retrievedTopic = $app->findTopicById($topic->getId());
        $this->assertEquals($topic, $retrievedTopic);
    }

    public function testFindTopicById_nonExistingTopicId_throwsTopicNotFoundException()
    {
        $app = ObvForumCreator::createObvForum();
        $this->expectException(TopicNotFoundException::class);
        $app->findTopicById("this id does not exist");
    }

    public function testGetAllTopicsByCategory_categoryWithMultipleTopics_returnsArrayOfThoseTopics()
    {
        $app = ObvForumCreator::createObvForum();
        $category = $app->createCategory("PHP Development");
        $javaCategory = $app->createCategory("Java Development");
        $app->createTopic('How to create PHP forum software?', 'Keep watching the stream.', $category->getId());
        $app->createTopic('Java Streams and Optional', '', $javaCategory->getId());
        $app->createTopic('Do you like PHP?', 'Is PHP a great language. Is it better than Java?', $category->getId());
        $result = $app->getTopicsInCategory($category->getId());
        $this->assertCount(2, $result);
    }
}