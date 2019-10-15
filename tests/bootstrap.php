<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';


spl_autoload_register(function(string $classname) {
    $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . $classname . '.php';
    if (is_file($filePath))
    {
        require_once $filePath;
    }
});