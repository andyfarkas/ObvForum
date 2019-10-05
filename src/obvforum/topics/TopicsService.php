<?php

namespace Obv\ObvForum\Topics;

use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\Storage\Storage;

class TopicsService
{
    private $categoriesService;

    private $storage;
    private $currentIdentifier = 1;

    public function __construct(Storage $storage, CategoriesService $categoriesService)
    {
        $this->storage = $storage;
        $this->categoriesService = $categoriesService;
    }

    public function create(string $title, string $description, Category $category) : Topic
    {
        if(!$this->categoriesService->exists($category))
        {
            throw new CategoryNotFoundException("Could not create topic for category that does not exist.");
        }

        $topic = new Topic(
            $this->currentIdentifier++,
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
                    ->filter(function(array $item) use($id){
                        return $item['_id'] == $id;
                    })->map(function(array $data){
                        return new Topic(
                            $data['_id'],
                            $data['_title'],
                            $data['_text'],
                            $data['_createdAt'],
                            $data['_createdBy'],
                            $data['_category']
                        );
                    })->findOne()
                    ->elseThrow(TopicNotFoundException::class);
    }
}