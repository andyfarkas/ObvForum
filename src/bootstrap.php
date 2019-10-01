<?php

spl_autoload_register(function(string $classname) {
    
    $pathParts = explode('\\', $classname);
    if (count($pathParts) < 2)
    {
        return;
    }
    
    if (strcasecmp($pathParts[0], 'ObvForum') != 0)
    {
        return;
    }
    
    array_shift($pathParts);
    
    $filename = array_pop($pathParts) . '.php';    
    $loweredPathParts = array_map('strtolower', $pathParts);
    $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR 
                . 'src' . DIRECTORY_SEPARATOR
                . implode(DIRECTORY_SEPARATOR, $loweredPathParts) . DIRECTORY_SEPARATOR 
                . $filename;
    
    if (file_exists($filePath))
    {
        require_once $filePath;
    }    
});