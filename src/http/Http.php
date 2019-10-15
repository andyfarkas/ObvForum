<?php

namespace Obv\Http;

class Http
{
    const GET = 'GET';
    const PUT = 'PUT';

    private $routes = array();

    public function get(string $path, \Closure $callback)
    {
        $this->addRoute(self::GET, $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        $method = strtoupper($method);
        if (!array_key_exists($method,$this->routes))
        {
            $this->routes[$method] = [];
        }

        $this->routes[$method][$path] = $callback;
    }

    public function run()
    {
        $request = new Request();

        header('Content-type: application/json');
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'];

        if (!array_key_exists($method, $this->routes))
        {
            http_response_code(400);
            echo json_encode([
                'error' => 'Path not found',
            ]);
            exit;
        }

        foreach ($this->routes[$method] as $path => $callback)
        {
            if (strcasecmp($path, $uri) == 0)
            {
                echo $this->handleRequest($request, $callback);
                exit;
            }
        }

        http_response_code(400);
        echo json_encode([
            'error' => 'Path not found',
        ]);
        exit;
    }

    private function handleRequest(Request $request, \Closure $callback) : string
    {
        try
        {
            $result = $callback($request);
        }
        catch (\Exception $e)
        {
            http_response_code(400);
            $result = [
                'error' => $e->getMessage()
            ];
        }

        return json_encode($result);
    }

    public function put(string $path, \Closure $callback)
    {
        $this->addRoute(self::PUT, $path, $callback);
    }
}