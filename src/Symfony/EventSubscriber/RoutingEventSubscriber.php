<?php
declare(strict_types=1);

namespace Symfony\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class RoutingEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::EXCEPTION => 'methodNotAllowed'
        ];
    }

    public function methodNotAllowed(ExceptionEvent $event) : void
    {
        if ($event->getException() instanceof MethodNotAllowedException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Method not allowed'], 400)
            );
        }

        if ($event->getException() instanceof RouteNotFoundException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Route not found'], 404)
            );
        }
    }
}
