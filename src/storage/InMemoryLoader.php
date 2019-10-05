<?php

namespace Obv\Storage;

class InMemoryLoader implements Loader
{
    private $data;

    private $conditions;

    private $mapper;

    private $isFindOne = false;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function findOne() : Loader
    {
        $this->isFindOne = true;
        return $this;
    }

    public function map(\Closure $mapper) : Loader
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function filter(array $conditions) : Loader
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function elseThrow(string $exception)
    {
        $result = $this->getFilteredData();

        if ($this->mapper != null)
        {
            $result = array_map($this->mapper, $result);
        }

        if ($this->isFindOne)
        {
            if (empty($result))
            {
                throw new $exception("Could not find item.");
            }

            return array_pop($result);
        }

        return $result;
    }

    public function findAll()
    {
        $result = $this->getFilteredData();

        if ($this->mapper != null)
        {
            $result = array_map($this->mapper, $result);
        }

        return $result;
    }

    private function getFilteredData() : array
    {
        if ($this->conditions != null)
        {
            return array_filter($this->data, function($item) {
                foreach ($this->conditions as $field => $value)
                {
                    if ($item[$field] != $value)
                    {
                        return false;
                    }
                }

                return true;
            });
        }

        return $this->data;
    }
}
