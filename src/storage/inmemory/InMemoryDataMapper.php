<?php

namespace Obv\Storage\InMemory;

use Obv\Storage\DataMapper;

class InMemoryDataMapper implements DataMapper
{
    public function asDate($subject): \DateTime
    {
        return $subject;
    }
}