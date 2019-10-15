<?php

namespace Obv\Storage\InMemory;

use Obv\Storage\Loader;

class InMemoryLoader implements Loader
{
    private $data;
    private $conditions;
    private $mapper;
    private $isFindOne = false;
    private $orderBy;

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
        $result = $this->data;
        if ($this->conditions != null)
        {
            $result = array_filter($this->data, function($item) {
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

        if ($this->orderBy != null)
        {
            $field = array_keys($this->orderBy)[0];
            $direction = array_values($this->orderBy)[0];
            usort($result, function(array $first, array $second) use ($field, $direction) {
                if ($first[$field] instanceof \DateTime)
                {
                    $result = $first[$field]->diff($second[$field])->invert > 0 ? -1 : 1;
                    $result = strcasecmp($direction, 'desc') != 0 ? $result * -1 : $result;
                    return $result;
                }

                return $first[$field] - $second[$field];
            });
        }

        return $result;
    }

    public function orderBy(array $orderBy): Loader
    {
        $this->orderBy = $orderBy;
        return $this;
    }
}
