<?php

namespace Obv\Storage\File;

use Obv\Storage\DataMapper;

class FileDataMapper implements DataMapper
{
    public function asDate($subject): \DateTime
    {
        return new \DateTime($subject['date']);
    }
}