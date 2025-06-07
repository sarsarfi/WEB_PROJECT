<?php
namespace App;

class Route
{
    private $routes = [];
    private $basePath = '';

    public function __construct()
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (strpos($requestUri, $scriptName) === 0) {
            $this->basePath = dirname($scriptName);
        } elseif (strpos($requestUri, dirname($scriptName)) === 0) {
            $this->basePath = dirname($scriptName);
        } else {
            // اگر پروژه در ساب دایرکتوری ثابت است
            $this->basePath = '/web_project';
        }
        $this->basePath = rtrim($this->basePath, '/');
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function get($uri, $handler)
    {
        $this->addRoute('GET', $uri, $handler);
    }

    public function post($uri, $handler)
    {
        $this->addRoute('POST', $uri, $handler);
    }

    private function addRoute($method, $uri, $handler)
    {
        // جایگزینی :id و :any با regex
        $uri = str_replace([':id', ':any'], ['([0-9]+)', '([^/]+)'], $uri);
        // **حذف basePath از اینجا**
        $uri = '#^' . preg_quote($uri, '#') . '$#'; // فقط خود URI با شروع و پایان کامل
        $this->routes[$method][$uri] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // حذف basePath برای تطبیق صحیح با روت‌ها
        $uri = str_replace($this->basePath, '', $uri);
        $uri = '/' . ltrim($uri, '/');

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            if (preg_match($route, $uri, $matches)) {
                array_shift($matches);

                if (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                } elseif (is_array($handler) && count($handler) === 2) {
                    $controllerName = $handler[0];
                    $methodName = $handler[1];

                    if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                        call_user_func_array([$controllerName, $methodName], $matches);
                    } else {
                        http_response_code(500);
                        echo "Controller or method not found.";
                        exit();
                    }
                }
                return;
            }
        }

        // روت پیدا نشد → صفحه 404
        http_response_code(404);
        view('404.php');
        exit();
    }
}
