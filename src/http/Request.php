<?php

namespace Obv\Http;

class Request
{
    public function read() : array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}