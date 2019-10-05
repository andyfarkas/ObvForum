<?php

namespace Obv\ObvForum\Categories;

use Obv\Storage\Storage;

class CategoriesService
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function create(string $name) : Category
    {
        $category = new Category(uniqid(), $name);
        $this->storage->store(array(
            '_id' => $category->getId(),
            '_name' => $category->getName(),
        ));

        return $category;
    }

    public function findById(string $id) : Category
    {
        return $this->storage
                    ->load()
                    ->filter(array(
                        '_id' => $id,
                    ))->findOne()
                    ->map(function(array $data){
                        return new Category($data['_id'], $data['_name']);
                    })->elseThrow(CategoryNotFoundException::class);
    }

    public function update(Category $category)
    {
        $this->storage->replace(array(
            '_id' => $category->getId(),
            '_name' => $category->getName(),
        ), array(
            '_id' => $category->getId()
        ));
    }

    public function exists(Category $category)
    {
        $result = $this->storage->load()
                        ->filter(array(
                            '_id' => $category->getId(),
                        ))->findAll();

        return !empty($result);
    }

    /**
     * @return Category[]
     */
    public function findAll() : array
    {
        return $this->storage->load()
            ->map(function(array $data) {
                return new Category($data['_id'], $data['_name']);
            })->findAll();
    }

}
