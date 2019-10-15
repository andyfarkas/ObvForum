<?php

namespace Obv\Storage\InMemory;

use Obv\Storage\Loader;
use Obv\Storage\Storage;

class InMemoryStorage implements Storage
{
    private $data = array();

    public function store(array $subject)
    {
        $this->data[] = $subject;
    }

    public function load() : Loader
    {
        return new InMemoryLoader($this->data);
    }

    public function replace(array $data, array $criteria)
    {
        $result = array_filter($this->data, function(array $item) use($criteria) {
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
            $this->data[$key] = $data;
        }
    }
}