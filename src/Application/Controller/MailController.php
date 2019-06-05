<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Command\SavePostDataToJsonCommand;
use Domain\Address\Referer;
use Domain\Host;
use Infrastructure\HostFactory;
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
        return new Response('Created by Zbigniew @Ferror Malcherczyk');
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function saveToJson(Request $request)
    {
        $host = HostFactory::fromRequest($request);

        if (!$host->isSecure()) {
            throw new \Exception('Url must be SSL');
        }

        if ($this->isOnWhitelist($host)) {
            $this->handle(new SavePostDataToJsonCommand($host, $request->request->all()));

            if ($request->get('_next')) {
                return new RedirectResponse(
                    $request->get('_next'),
                    302
                );
            }

            return new JsonResponse([], 204);
        }

        return new JsonResponse(['error' => 'Not on whitelist'], 400);
    }

    /**
     * @Route("/{uuid}", methods={"POST"})
     */
    public function saveToMail(Request $request, string $uuid) : Response
    {
        return new JsonResponse(
            [
                'data' => $request->request->all(),
                'host' => $request->getHost(),
            ],
            200
        );
    }

    private function isOnWhitelist(Host $host) : bool
    {
        $file = file_get_contents($this->getParameter('kernel.project_dir') . '/data/whitelist.json');

        return in_array((string) $host, json_decode($file, true), true);
    }
}
