<?php

namespace Obv\Storage;

class FileDataMapper implements DataMapper
{
    public function asDate($subject): \DateTime
    {
        return new \DateTime($subject['date']);
    }
}