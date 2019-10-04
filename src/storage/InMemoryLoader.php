<?php

namespace ObvForum\Storage;

class InMemoryLoader implements Loader
{
    private $data;

    private $filter;

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

    public function filter(\Closure $filter) : Loader
    {
        $this->filter = $filter;
        return $this;
    }

    public function elseThrow(string $exception)
    {
        $result = $this->data;

        if ($this->filter != null)
        {
            $result = array_filter($this->data, $this->filter);
        }

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
        $result = $this->data;

        if ($this->filter != null)
        {
            $result = array_filter($this->data, $this->filter);
        }

        if ($this->mapper != null)
        {
            $result = array_map($this->mapper, $result);
        }

        return $result;
    }
}
