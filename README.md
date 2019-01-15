# Symfony 4 Simple Middleware #
Provides symfony 4 simple middleware by forwarding event ```kernel.request``` and ```kernel.response``` to your middleware
## Getting Started ##
### Installation ###
```composer require fys/middleware-bundle```
### Creating your first middleware ###
- Create service definition for your middleware class and tag ```middleware``` on your service definition (in this case we will create ```AuthMiddleware``` in ```App\Middleware\AuthMiddleware```)
```
// app/config/services.yaml
services:
    App\Middleware\AuthMiddleware:
        tags: ["middleware"]
```

```
// App\Middleware\AuthMiddleware

<?php

namespace App\Middleware\AuthMiddleware;

use FYS\MiddlewareBundle\Contract\MiddlewareInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AuthMiddleware implements  MiddlewareInterface
{
    public function getAlias()
    {
        return 'auth';
    }
    
    public function onRequest(GetResponseEvent $event)
    {
        // do your action here
    }
    
    public function onResponse(FilterResponseEvent $event)
    {
        // do your action here
    }
}
```
- apply your middleware in controller by implements ```FYS\MiddlewareBundle\Contract\MiddlewareControllerInterface```, by implementing this interface, your controller should have ```runMiddleware()``` method with return ```string```
```
// App\Controller\TestController

<?php

namespace App\Controller\TestController;

use FYS\MiddlewareBundle\Contract\MiddlewareControllerInterface;

class TestController
{
    // your logic controller
    
    public function runMiddleware()
    {
        return 'auth';
    }
}
```

- Done! now every request to TestController will apply AuthMiddleware
