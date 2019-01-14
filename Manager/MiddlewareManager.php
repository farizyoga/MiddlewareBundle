<?php

namespace FYS\MiddlewareBundle\Manager;

use FYS\MiddlewareBundle\Contract\MiddlewareInterface;
use Exception;

class MiddlewareManager
{
	private $middlewares;

	public function __construct()
	{
		$this->middlewares = [];
	}

	public function addMiddleware(MiddlewareInterface $middleware)
	{
		$this->middlewares[$middleware->getAlias()] = $middleware;
	}

	public function get($key)
	{
		if (!array_key_exists($key, $this->middlewares)) {
			throw new Exception('Middleware '.$key.' Not Found');
		}

		return $this->middlewares[$key];
	}
}