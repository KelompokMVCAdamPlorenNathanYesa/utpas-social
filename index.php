<?php

class Route {
	public static function route($route, $handler){
		$callback = $handler;
		if (!is_callable($callback)){
			if(!strpos($handler, '.php')){
				$handler .= '.php'; 
			}
		}
		if ($route == "/404"){
			include_once __DIR__ . "/$handler";
			exit();
		}
		$request_url =  filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
		$request_url = rtrim($request_url, '/');
		$request_url = strtok($request_url, '?'); 
		$route_parts = explode('/', $route);
		$request_url_parts = explode('/', $request_url);
		array_shift($route_parts);
		array_shift($request_url_parts);
		if ($route_parts[0] == '' && count($request_url_parts)== 0){
			if(is_callable($callback)){
				call_user_func_array($callback, []);
				exit();
			}
			include_once __DIR__ . "/$handler";
			exit();
		}
		if (count($route_parts) != count($request_url_parts)){
			// var_dump("Dump");
			return;
		}
		$parameters = [];
		for ($i = 0; $i < count($route_parts); $i++){
		$route_part = $route_parts[$i];
		if(preg_match("/^[$]/", $route_part)){
			$route_part = ltrim($route_part, '$');
			array_push($parameters, $request_url_parts[$i]);
			$$route_part = $request_url_parts[$i];
		} else if ($route_parts[$i] != $request_url_parts[$i]){
			return;
		}
		}
		if (is_callable($callback)){
			call_user_func_array($callback, $parameters);
			exit();
		}
		include_once __DIR__ . "/$handler";
		exit();
	}

	public static function get($route, $handler){
		if ($_SERVER['REQUEST_METHOD'] == 'GET'){
			self::route($route, $handler);
		}
	}
	public static function post($route, $handler){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			self::route($route, $handler);
		}
	}

	public static function put($route, $handler){
		if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
			self::route($route, $handler);
		}
	}

	public static function delete($route, $handler){
		if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
			self::route($route, $handler);
		}
	}

}

require_once "./route.php";