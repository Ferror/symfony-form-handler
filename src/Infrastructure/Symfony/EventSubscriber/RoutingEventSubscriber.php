<?php
declare(strict_types=1);

namespace Infrastructure\Symfony\EventSubscriber;

use Application\Exception\HoneyPotFoundException;
use Application\Exception\Invalid\InvalidHostSchemaException;
use Application\Exception\NotFound\RequestHeaderNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

final class RoutingEventSubscriber implements EventSubscriberInterface
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

        if ($exception instanceof RequestHeaderNotFoundException) {
            $event->setResponse(
                new JsonResponse(['error' => $exception->getMessage()], 400)
            );
        }

        if ($exception instanceof InvalidHostSchemaException) {
            $event->setResponse(
                new JsonResponse(['error' => $exception->getMessage()], 400)
            );
        }

        if ($exception instanceof HoneyPotFoundException) {
            $event->setResponse(
                new RedirectResponse('https://www.wikipedia.org', 301)
            );
        }
    }
}
