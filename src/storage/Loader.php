<?php

namespace Obv\Storage;

interface Loader
{
    public function findOne() : self;
    public function findAll();
    public function map(\Closure $mapper) : self;
    public function filter(\Closure $filter) : self;
    public function elseThrow(string $exception);
}

