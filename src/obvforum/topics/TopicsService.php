<?php

namespace Obv\ObvForum\Topics;

use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\Storage\DataMapper;
use Obv\Storage\Storage;

class TopicsService
{
    private $categoriesService;
    private $storage;
    private $dataMapper;

    public function __construct(Storage $storage, CategoriesService $categoriesService, DataMapper $mapper)
    {
        $this->storage = $storage;
        $this->categoriesService = $categoriesService;
        $this->dataMapper = $mapper;
    }

    public function create(string $title, string $description, Category $category) : Topic
    {
        if(!$this->categoriesService->exists($category))
        {
            throw new CategoryNotFoundException("Could not create topic for category that does not exist.");
        }

        $topic = new Topic(
            uniqid(),
            $title,
            $description,
            new \DateTime(),
            'anonymous',
            $category->getId()
        );

        $this->storage->store(array(
            '_id' => $topic->getId(),
            '_title' => $topic->getTitle(),
            '_text' => $topic->getText(),
            '_createdBy' => $topic->getCreatedBy(),
            '_createdAt' => $topic->getCreatedAt(),
            '_category' => $topic->getCategory(),
        ));

        return $topic;
    }

    public function findById(string $id) : Topic
    {
        return $this->storage->load()
                    ->filter(array(
                        '_id' => $id,
                    ))->map(function(array $data){
                        return new Topic(
                            $data['_id'],
                            $data['_title'],
                            $data['_text'],
                            $this->dataMapper->asDate($data['_createdAt']),
                            $data['_createdBy'],
                            $data['_category']
                        );
                    })->findOne()
                    ->elseThrow(TopicNotFoundException::class);
    }

    /**
     * @param string $categoryId
     * @return Topic[]
     */
    public function getAllByCategoryId(string $categoryId) : array
    {
        return $this->storage->load()
            ->filter(array(
                '_category' => $categoryId
            ))->map(function(array $data){
                return new Topic(
                    $data['_id'],
                    $data['_title'],
                    $data['_text'],
                    $this->dataMapper->asDate($data['_createdAt']),
                    $data['_createdBy'],
                    $data['_category']
                );
            })->findAll();
    }
}