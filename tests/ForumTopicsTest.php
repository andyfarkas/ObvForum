<?php

use Obv\ObvForum;
use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\ObvForum\Replies\RepliesService;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicNotFoundException;
use Obv\ObvForum\Topics\TopicsService;
use Obv\Storage\InMemoryDataMapper;
use Obv\Storage\InMemoryStorage;
use PHPUnit\Framework\TestCase;

class ForumTopicsTest extends TestCase
{
    public function testCreateTopic_validData_returnsCreatedTopic()
    {
        $app = $this->createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category->getId());
        $this->assertInstanceOf(Topic::class, $topic);
    }

    public function testCreateTopic_nonExistingCategory_throwsCategoryNotFoundException()
    {
        $app = $this->createObvForum();
        $category = new Category("some id", "This category does not exist");

        $this->expectException(CategoryNotFoundException::class);
        $app->createTopic("A new topic", "Some description", $category->getId());
    }

    public function testFindTopicById_existingTopic_returnsThatTopic()
    {
        $app = $this->createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic("A new topic", "Some description", $category->getId());
        $retrievedTopic = $app->findTopicById($topic->getId());
        $this->assertEquals($topic, $retrievedTopic);
    }

    public function testFindTopicById_nonExistingTopicId_throwsTopicNotFoundException()
    {
        $app = $this->createObvForum();
        $this->expectException(TopicNotFoundException::class);
        $app->findTopicById("this id does not exist");
    }

    public function testGetAllTopicsByCategory_categoryWithMultipleTopics_returnsArrayOfThoseTopics()
    {
        $app = $this->createObvForum();
        $category = $app->createCategory("PHP Development");
        $javaCategory = $app->createCategory("Java Development");
        $app->createTopic('How to create PHP forum software?', 'Keep watching the stream.', $category->getId());
        $app->createTopic('Java Streams and Optional', '', $javaCategory->getId());
        $app->createTopic('Do you like PHP?', 'Is PHP a great language. Is it better than Java?', $category->getId());
        $result = $app->getTopicsInCategory($category->getId());
        $this->assertCount(2, $result);
    }

    /**
     * @return ObvForum
     */
    private function createObvForum(): ObvForum
    {
        $categoriesService = new ObvForum\Categories\CategoriesService(
            new InMemoryStorage()
        );
        $topicsService = new ObvForum\Topics\TopicsService(
            new InMemoryStorage(),
            $categoriesService,
            new InMemoryDataMapper()
        );
        $repliesService = new RepliesService(
            new InMemoryStorage(),
            new InMemoryDataMapper(),
            $topicsService
        );
        return new ObvForum(
            $categoriesService,
            $topicsService,
            $repliesService
        );
    }
}