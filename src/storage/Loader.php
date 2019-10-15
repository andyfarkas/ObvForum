<?php

namespace Obv\Storage;

interface Loader
{
    public function findOne() : self;
    public function findAll();
    public function map(\Closure $mapper) : self;
    public function filter(array $conditions) : self;
    public function elseThrow(string $exception);
    public function orderBy(array $orderBy) : self;
}

