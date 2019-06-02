<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Exception\HoneyPotFoundException;
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
     *
     * @param Request $request
     * @param string $uuid
     *
     * @throws HoneyPotFoundException
     * @throws HostNotWhitelisted
     *
     * @return Response
     */
    public function mail(Request $request, string $uuid) : Response
    {
        if (!$this->isOnWhitelist($request->headers->get('referer'))) {
            throw new HostNotWhitelisted('Provided site cannot be handled');
        }

        if ($request->get('_gotcha')) {
            throw new HoneyPotFoundException();
        }

        //"HTTP_ORIGIN" => "https://malcherczyk.com";
        //"HTTP_REFERER" => "https://malcherczyk.com/";

        $fileName = 'form' . random_int(0, 100) . '.json';
        $file = fopen($this->getParameter('kernel.project_dir') . '/data/content/' . $fileName , 'wb');
        fwrite($file, json_encode($request->request->all()));
        fclose($file);

        if ($request->get('_next')) {
            return new RedirectResponse(
                $request->get('_next'),
                302
            );
        }

        return new JsonResponse(
            [
                'data' => $request->request->all(),
                'host' => $request->getHost(),
            ],
            200,
            [
                'Access-Control-Allow-Headers' => 'Origin',
                'Access-Control-Allow-Origin' => '*',
            ]
        );
    }

    private function isOnWhitelist(string $host) : bool
    {
        $file = file_get_contents($this->getParameter('kernel.project_dir') . '/data/whitelist.json');

        return in_array($host, json_decode($file, true), true);
    }
}
