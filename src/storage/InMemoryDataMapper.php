<?php

namespace Obv\Storage;

class InMemoryDataMapper implements DataMapper
{
    public function asDate($subject): \DateTime
    {
        return $subject;
    }
}