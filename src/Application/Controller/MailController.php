<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Exception\HostNotWhitelisted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Controller\SymfonyController;

final class MailController extends SymfonyController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index() : Response
    {
        return new JsonResponse(['OK']);
    }


    /**
     * @Route("/{uuid}", methods={"POST"})
     */
    public function mail(Request $request, string $uuid) : Response
    {
        //request posiada hosta, uuid z urla i form values

        if ($request->getHost() === 'https://malcherczyk.com/') {
            return new JsonResponse([
                'data' => $request->request->all(),
                'host' => true,
            ]);
        }

        if (!$this->isOnWhitelist($request->getHost())) {
            throw new HostNotWhitelisted();
        }

        $fileName = 'form' . random_int(0, 100) . '.json';
        $file = fopen($this->getParameter('kernel.project_dir') . '/data/content/' . $fileName , 'w');
        fwrite($file, json_encode($request->request->all()));
        fclose($file);

//        $message = (new \Swift_Message())
//            ->setSubject('Hello Email')
//            ->setFrom('send@example.com')
//            ->setTo('recipient@example.com')
//            ->setBody($this->renderView('email.html.twig'), 'text/html');
//        $this->getSwiftMailer()->send($message);

        if ($request->get('_next')) {
            return new RedirectResponse(
                $request->get('_next'),
                302
            );
        }

        return new JsonResponse([
            'data' => $request->request->all(),
            'host' => $request->getHost(),
        ]);
    }

    private function isOnWhitelist(string $host) : bool
    {
        $file = file_get_contents($this->getParameter('kernel.project_dir') . '/data/whitelist.json');

        return in_array($host, json_decode($file, true), true);
    }
}
