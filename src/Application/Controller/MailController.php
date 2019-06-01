<?php
declare(strict_types=1);

namespace Application\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Controller\SymfonyController;

final class MailController extends SymfonyController
{
    /**
     * @Route("/{uuid}", methods={"POST", "GET"})
     */
    public function mail(Request $request, string $uuid) : JsonResponse
    {
        //request posiada hosta, uuid z urla i form values

        if ($request->getHost() === 'https://malcherczyk.com/') {
            return new JsonResponse([
                'data' => $request->request->all(),
                'host' => true,
            ]);
        }

//        $message = (new \Swift_Message())
//            ->setSubject('Hello Email')
//            ->setFrom('send@example.com')
//            ->setTo('recipient@example.com')
//            ->setBody($this->renderView('email.html.twig'), 'text/html');
//        $this->getSwiftMailer()->send($message);

        return new JsonResponse([
            'data' => $request->request->all(),
            'host' => $request->getHost(),
        ]);
    }
}
