<?php

namespace Obv\Storage\File;

use Obv\Storage\InMemory\InMemoryLoader;
use Obv\Storage\Loader;
use Obv\Storage\Storage;
use PHPUnit\phpDocumentor\Reflection\Types\This;

class FileStorage implements Storage
{
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function store(array $data)
    {
        $storage = [];
        if (is_file($this->file))
        {
            $contents = file_get_contents($this->file);
            $storage = json_decode($contents);
        }

        $storage[] = $data;
        $encoded = json_encode($storage);
        file_put_contents($this->file, $encoded);
    }

    public function load(): Loader
    {
        $storage = [];
        if (is_file($this->file))
        {
            $contents = file_get_contents($this->file);
            $storage = json_decode($contents, true);
        }

        return new InMemoryLoader($storage);
    }

    public function replace(array $data, array $criteria)
    {
        $contents = file_get_contents($this->file);
        $storage = json_decode($contents);

        $result = array_filter($storage, function(array $item) use($criteria) {
            foreach($criteria as $field => $value)
            {
                if ($item[$field] != $value)
                {
                    return false;
                }
            }

            return true;
        });

        foreach(array_keys($result) as $key)
        {
            $storage[$key] = $data;
        }

        $encoded = json_encode($storage);
        file_put_contents($this->file, $encoded);
    }
}