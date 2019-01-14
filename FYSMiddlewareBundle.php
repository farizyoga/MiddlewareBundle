<?php

namespace FYS\MiddlewareBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use FYS\MiddlewareBundle\DependencyInjection\Compiler\MiddlewarePass;

class FYSMiddlewareBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new MiddlewarePass());
	}
}