<?php

namespace Obv;

use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Categories\Category;
use Obv\Storage\InMemoryStorage;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicsService;
use Obv\Storage\Storage;

class ObvForum
{
    private $categoriesService;
    private $topicsService;

    public function __construct(
        Storage $categoriesStorage,
        Storage $topicsStorage
    )
    {
        $this->categoriesService = new CategoriesService($categoriesStorage);
        $this->topicsService = new TopicsService($topicsStorage, $this->categoriesService);
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