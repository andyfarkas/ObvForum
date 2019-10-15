<?php

use Obv\Http\Http;
use Obv\Http\Request;
use Obv\ObvForum;
use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Replies\RepliesService;
use Obv\ObvForum\Topics\TopicsService;
use Obv\Storage\File\FileDataMapper;
use Obv\Storage\File\FileStorage;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$categoriesService = new CategoriesService(new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'ui' . DIRECTORY_SEPARATOR . 'categories.json'));
$topicsService = new TopicsService(
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'ui' . DIRECTORY_SEPARATOR . 'topics.json'),
    $categoriesService,
    new FileDataMapper()
);

$repliesService = new RepliesService(
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'ui' . DIRECTORY_SEPARATOR . 'replies.json'),
    new FileDataMapper(),
    $topicsService
);
$app = new ObvForum(
    $categoriesService,
    $topicsService,
    $repliesService
);

$http = new Http();

$http->get('/api/forum/categories', function() use($app) {
    return array_map(function(ObvForum\Categories\Category $category) {
        return array(
            'id' => $category->getId(),
            'name' => $category->getName(),
        );
    }, $app->getAllCategories());
});

$http->get('/api/forum/categories/{id}', function(Request $request) use($app) {
    $topics = $app->getTopicsInCategory($request->get('id')); //@TODO
});

$http->put('/api/forum/categories', function(Request $request) use($app) {
    $contents = $request->read();
    $name = trim($contents['name']);
    if (strlen($name) < 5)
    {
        throw new InvalidArgumentException("Category name too short");
    }

    $category = $app->createCategory($contents['name']);
    return array(
        'id' => $category->getId(),
        'name' => $category->getName()
    );
});

$http->run();