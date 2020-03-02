<?php

class Route
{
	public static function get ($route, $controller) {
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') return;

		if (self::check($route)) {
			require 'controllers/' . $controller . '.php';
			die();
		}
	}

	public static function put ($route, $controller) {
		if ($_SERVER['REQUEST_METHOD'] !== 'PUT') return;

		if (self::check($route)) {
			require 'controllers/' . $controller . '.php';
			die();
		}
	}

	public static function error ($controller) {
		require 'controllers/' . $controller . '.php';
	}

	public static function check ($route) {
		$url = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
		$url = array_filter(explode('/', $url), function ($el) {
			return true;
		});
		$arr_route = array_filter(explode('/', $route), function ($el) {
			return $el;
		});
		$res = array();
		$vars = array();

		foreach ($arr_route as $n=>$el) {
			if (strpos($el, '{') === false) {
				if ($el === $url[$n]) {
					$res[$n] = 1;
				} else {
					$res[$n] = 0;
				}
			} else {
				$res[$n] = 1;
				$var = str_ireplace(['{', '}'], '', $el);
				global $$var;
				$$var = $url[$n];
				$vars[$var] = $url[$n];
			}
		}

		$correct = array_reduce($res, function($carry, $item){
			return (bool)$res = $carry && (bool)$item;
		}, true);

		return $correct;
	}
}