<?php

use Obv\ObvForum;
use Obv\Storage\FileStorage;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new ObvForum(
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'categories.json'),
    new FileStorage(__DIR__ . DIRECTORY_SEPARATOR . 'topics.json')
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

$categories = $app->getAllCategories();

require_once "template.php";
