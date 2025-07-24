<?php 

class Route {
    public static function route($route, $handler) {
        $callback = $handler;

        // Jika bukan callable dan string (misal file .php), cek .php-nya
        if (!is_callable($callback)) {
            if (is_string($handler) && !str_contains($handler, '.php')) {
                $handler .= '.php';
            }
        }

        // Jika route 404
        if ($route == "/404") {
            include_once __DIR__ . "/$handler";
            exit();
        }

        // Ambil dan normalisasi URL request
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?'); 

        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);

        array_shift($route_parts);
        array_shift($request_url_parts);

        // Cek root /
        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            if (is_callable($callback)) {
                call_user_func_array($callback, []);
                exit();
            }
            include_once __DIR__ . "/$handler";
            exit();
        }

        // Jumlah bagian path harus sama
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }

        // Cek parameter
        $parameters = [];
        for ($i = 0; $i < count($route_parts); $i++) {
            $route_part = $route_parts[$i];
            if (preg_match("/^[$]/", $route_part)) {
                $route_part = ltrim($route_part, '$');
                array_push($parameters, $request_url_parts[$i]);
                $$route_part = $request_url_parts[$i];
            } else if ($route_parts[$i] != $request_url_parts[$i]) {
                return;
            }
        }

        // Panggil handler
        if (is_callable($callback)) {
            call_user_func_array($callback, $parameters);
            exit();
        }

        // Atau include file
        if (is_string($handler)) {
            include_once __DIR__ . "/$handler";
            exit();
        }
    }

    public static function get($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::route($route, $handler);
        }
    }

    public static function post($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::route($route, $handler);
        }
    }

    public static function put($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            self::route($route, $handler);
        }
    }

    public static function delete($route, $handler) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            self::route($route, $handler);
        }
    }
}
