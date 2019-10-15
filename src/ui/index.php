<?php

use Obv\Http\Http;
use Obv\ObvForum;
use Obv\ObvForum\Categories\CategoriesService;
use Obv\ObvForum\Replies\RepliesService;
use Obv\Storage\File\FileDataMapper;
use Obv\Storage\File\FileStorage;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$categoriesService = new CategoriesService(new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'categories.json'));
$topicsService = new ObvForum\Topics\TopicsService(
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'topics.json'),
    $categoriesService,
    new FileDataMapper()
);

$repliesService = new RepliesService(
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'replies.json'),
    new FileDataMapper(),
    $topicsService
);
$app = new ObvForum(
    $categoriesService,
    $topicsService,
    $repliesService
);

if (isset($_POST['btnCreateCategory']))
{
    if (array_key_exists('categoryName', $_POST))
    {
        if (strlen($_POST['categoryName']) > 1)
        {
            $app->createCategory($_POST['categoryName']);
            header('Location: /');
            exit;
        }
    }
}

if (isset($_POST['btnCreateTopic']))
{
    if (!array_key_exists('topicTitle', $_POST))
    {
        header('Location: /');
    }

    if (strlen($_POST['topicTitle']) < 2)
    {
        header('Location: /');
    }

    $app->createTopic($_POST['topicTitle'], $_POST['topicText'], $_POST['categoryId']);
    header('Location: /');
}

$categories = $app->getAllCategories();
$categoryTopics = array();
foreach ($categories as $category)
{
    $categoryTopics[$category->getId()] = $app->getTopicsInCategory($category->getId());
}

require_once "template.php";
