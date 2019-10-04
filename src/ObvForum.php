<?php

namespace ObvForum;

use ObvForum\Categories\CategoriesService;
use ObvForum\Categories\Category;
use ObvForum\Storage\InMemoryStorage;
use ObvForum\Topics\Topic;
use ObvForum\Topics\TopicsService;

class ObvForum
{
    private $categoriesService;
    private $topicsService;

    public function __construct()
    {
        $this->categoriesService = new CategoriesService(new InMemoryStorage());
        $this->topicsService = new TopicsService(new InMemoryStorage(), $this->categoriesService);
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

    public function createTopic(string $title, string $text, Category $category) : Topic
    {
        return $this->topicsService->create($title, $text, $category);
    }

    public function findTopicById(string $id) : Topic
    {
        return $this->topicsService->findById($id);
    }
}