<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';

// a hack because of old PHPStorm not supporting namespaced PHPUnit
class PHPUnit_Framework_TestCase extends \PHPUnit\Framework\TestCase
{

}