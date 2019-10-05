<?php

namespace Obv\Storage;

interface Storage
{
    public function store(array $data);
    public function load() : Loader;
    public function replace(array $data, array $criteria);
}