<?php

namespace FYS\MiddlewareBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use FYS\MiddlewareBundle\Manager\MiddlewareManager;
use Symfony\Component\DependencyInjection\Reference;

class MiddlewarePass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (!$container->has(MiddlewareManager::class)) {
			return;
		}

		$definition = $container->findDefinition(MiddlewareManager::class);
		$taggedServices = $container->findTaggedServiceIds('middleware');

		foreach ($taggedServices as $id => $tags) {
			$definition->addMethodCall('addMiddleware', [new Reference($id)]);
		}
	}
}