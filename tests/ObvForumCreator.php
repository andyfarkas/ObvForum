<?php

use Obv\ObvForum;
use Obv\ObvForum\Replies\RepliesService;
use Obv\Storage\InMemory\InMemoryDataMapper;
use Obv\Storage\InMemory\InMemoryStorage;

class ObvForumCreator
{
    /**
     * @return ObvForum
     */
    public static function createObvForum(): ObvForum
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