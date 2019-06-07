<?php
declare(strict_types=1);

namespace Symfony\EventSubscriber;

use Application\Exception\HoneyPotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $exception = $event->getException();

        if ($exception instanceof MethodNotAllowedException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Method not allowed'], 400)
            );
        }

        if ($exception instanceof RouteNotFoundException) {
            $event->setResponse(
                new JsonResponse(['error' => 'Route not found'], 404)
            );
        }

        if ($exception instanceof HoneyPotFoundException) {
            $event->setResponse(
                new RedirectResponse('https://www.wikipedia.org', 301)
            );
        }

        $event->setResponse(
            new JsonResponse(['error' => $exception->getMessage()], $exception->getCode())
        );
    }
}
