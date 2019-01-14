<?php

namespace FYS\MiddlewareBundle\Contract;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

interface MiddlewareInterface
{
	public function getAlias();
	public function onRequest(GetResponseEvent $event);
	public function onResponse(FilterResponseEvent $event);
}