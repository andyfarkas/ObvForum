<?php

namespace Obv;

use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Replies\RepliesService;
use Obv\ObvForum\Replies\Reply;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicsService;

class ObvForum
{
    private $categoriesService;
    private $topicsService;
    private $repliesService;

    public function __construct(
        CategoriesService $categoriesService,
        TopicsService $topicsService,
        RepliesService $repliesService
    )
    {
        $this->categoriesService = $categoriesService;
        $this->topicsService = $topicsService;
        $this->repliesService = $repliesService;
    }

    public function createCategory(string $name) : Category
    {
        return $this->categoriesService->create($name);
    }

    public function findCategoryById(string $id) : Category
    {
        return $this->categoriesService->findById($id);
    }

    public function updateCategory(Category $changedCategory)
    {
        $this->categoriesService->update($changedCategory);
    }

    /**
     * @return Category[]
     */
    public function getAllCategories() : array
    {
        return $this->categoriesService->findAll();
    }

    public function createTopic(string $title, string $text, string $categoryId) : Topic
    {
        return $this->topicsService->create($title, $text, $categoryId);
    }

    public function findTopicById(string $id) : Topic
    {
        return $this->topicsService->findById($id);
    }

    /**
     * @return Topic[]
     */
    public function getTopicsInCategory(string $categoryId) : array
    {
        return $this->topicsService->getAllByCategoryId($categoryId);
    }

    public function createReplyToTopic(string $contents, string $userId, string $topicId) : Reply
    {
        return $this->repliesService->createReply($contents, $userId, $topicId);
    }

    /**
     * @param string $topicId
     * @return Reply[]
     */
    public function getRepliesForTopic(string $topicId) : array
    {
        return $this->repliesService->getAllByTopic($topicId);
    }
}