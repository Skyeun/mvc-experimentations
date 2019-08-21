<?php


namespace Core\Router;


class Router
{
	/**
	 * @var array
	 */
	private static $routes = array();

	/**
	 * Simple route definition that work either with a callback function
	 * or with a a couple Controller::Action
	 *
	 * @param string $pattern
	 * @param $callback
	 */
	public static function route($pattern, $callback) {
		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

		if(is_string($callback)) {
			$callback = explode('::', $callback);
			$controller = 'App\Controllers\\'.$callback[0];
			$action = $callback[1];

			$class = new $controller;

			self::$routes[$pattern] = function() use (&$class, &$action) {
				$class->$action();
			};
		} else {
			self::$routes[$pattern] = $callback;
		}
	}

	/**
	 * @param $url
	 * @return mixed
	 */
	public static function execute($url) {
		foreach (self::$routes as $pattern => $callback) {
			if (preg_match($pattern, $url, $params)) {
				array_shift($params);
				return call_user_func_array($callback, array_values($params));
			}
		}
	}
}