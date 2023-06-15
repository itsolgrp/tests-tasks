<?php 

namespace App\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginListener
{
    protected $router;
    protected $security;
    protected $dispatcher;
    
    public function __construct(Router $router, SecurityContext $security, EventDispatcher $dispatcher)
    {
        $this->router = $router;
        $this->security = $security;
        $this->dispatcher = $dispatcher;
    }
    
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->dispatcher->addListener(KernelEvents::RESPONSE, array($this, 'onKernelResponse'));
    }
    
    public function onKernelResponse(FilterResponseEven $event)
    {
        // Important: redirect according to user Role
        if ($this->security->isGranted('ROLE_OWNER')) {
            $route = $this->router->generate("dashboard");
        } elseif ($this->security->isGranted('ROLE_WORKER')) {
            $route = $this->router->generate("bonus");
        } 
        $event->getResponse()->headers->set('Location', $route);
    }
}