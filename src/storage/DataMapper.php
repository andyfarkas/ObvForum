<?php

namespace Obv\Storage;

interface DataMapper
{
    public function asDate($subject) : \DateTime;
}