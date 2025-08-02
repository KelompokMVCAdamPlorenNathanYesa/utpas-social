<?php

class Route {
    
    public static function route($route, $handler) {
        if (!is_callable($handler) && is_string($handler)) {
            if (strpos($handler, '.php') === false) {
                $handler .= '.php';
            }
        }


        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');

        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);

        array_shift($route_parts); 
        array_shift($request_url_parts);

        if ($route_parts[0] === '' && count($request_url_parts) === 0) {
            return self::execute($handler, []);
        }

        if (count($route_parts) !== count($request_url_parts)) {
            return;
        }

        $parameters = [];
        for ($i = 0; $i < count($route_parts); $i++) {
            if (strpos($route_parts[$i], '$') === 0) {
                $parameters[] = $request_url_parts[$i];
            } elseif ($route_parts[$i] !== $request_url_parts[$i]) {
                return;
            }
        }

        self::execute($handler, $parameters);
    }

private static function execute($handler, $parameters) {
    if (is_callable($handler)) {
        if (is_array($handler) && count($handler) === 2 && is_string($handler[0]) && is_string($handler[1])) {
            $controllerClass = $handler[0];
            $methodName = $handler[1];


            $controller = new $controllerClass();

            call_user_func_array([$controller, $methodName], $parameters);

        } else {
            call_user_func_array($handler, $parameters);
        }
    } else {
        $file = __DIR__ . '/' . $handler;
        if (file_exists($file)) {
            include_once $file;
        } else {
            http_response_code(404);
            echo json_encode(['error' => '404 Not Found']);
        }
    }
    exit();
}

    public static function get($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::route($route, $handler);
        }
    }

    public static function post($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::route($route, $handler);
        }
    }

    public static function put($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            self::route($route, $handler);
        }
    }

    public static function delete($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            self::route($route, $handler);
        }
    }
}

class Middleware
{
    public static function auth()
    {
        // kalo blom login nggak boleh ke mana mana > kalo maksa redirect ke /login

        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
    public static function guest()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
    }
    public static function admin()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['status'] !== 'admin') {
            header('Location: /resource/views/403.php');
            exit;
        }
    }
}
