<?php
declare(strict_types=1);

namespace Infrastructure\Symfony\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

final class HttpEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::EXCEPTION => [
                'methodNotAllowed',
                'routeNotFound'
            ]
        ];
    }

    public function methodNotAllowed(ExceptionEvent $event) : void
    {
        if ($event->getException() instanceof MethodNotAllowedHttpException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Method not allowed'], 405)
            );
        }
    }

    public function routeNotFound(ExceptionEvent $event) : void
    {
        if ($event->getException() instanceof RouteNotFoundException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Not found'], 404)
            );
        }
    }
}
