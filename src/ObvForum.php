<?php

namespace Obv;

use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Topics\Topic;
use Obv\ObvForum\Topics\TopicsService;

class ObvForum
{
    private $categoriesService;
    private $topicsService;

    public function __construct(
        CategoriesService $categoriesService,
        TopicsService $topicsService
    )
    {
        $this->categoriesService = $categoriesService;
        $this->topicsService = $topicsService;
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

    public function getAllCategories() : array
    {
        return $this->categoriesService->findAll();
    }

    public function createTopic(string $title, string $text, Category $category) : Topic
    {
        return $this->topicsService->create($title, $text, $category);
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
}