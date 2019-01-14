<?php

namespace FYS\MiddlewareBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use FYS\MiddlewareBundle\Manager\MiddlewareManager;
use Symfony\Component\HttpKernel\Controller\TraceableControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use FYS\MiddlewareBundle\Contract\MiddlewareControllerInterface;

class MiddlewareSubscriber implements EventSubscriberInterface
{
	private $middlewareManager;
	private $controllerResolver;

	public function __construct(MiddlewareManager $middlewareManager, TraceableControllerResolver $controllerResolver)
	{
		$this->middlewareManager = $middlewareManager;
		$this->controllerResolver = $controllerResolver;
	}

	public static function getSubscribedEvents()
	{
		return [
			KernelEvents::REQUEST => 'forwardRequest',
			KernelEvents::RESPONSE => 'forwardResponse',
		];
	}

	public function getMiddleware(Request $request)
	{
		$controllers = $this->controllerResolver->getController($request);

		if (!is_array($controllers)) {
			return false;
		}

		$controller = $controllers[0];

		if (!$controller instanceof MiddlewareControllerInterface) {
			return false;
		}

		return $controller->runMiddleware();
	}

	public function forwardRequest(GetResponseEvent $event)
	{
		$middleware = $this->getMiddleware($event->getRequest());

		if (false === $middleware) {
			return;
		}

		$this->middlewareManager->get($middleware)->onRequest($event);
	}

	public function forwardResponse(FilterResponseEvent $event)
	{
		$middleware = $this->getMiddleware($event->getRequest());

		if (false === $middleware) {
			return;
		}

		$this->middlewareManager->get($middleware)->onResponse($event);
	}
}