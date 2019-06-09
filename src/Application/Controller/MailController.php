<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Command\SavePostDataToJsonCommand;
use Application\Exception\HoneyPotFoundException;
use Application\Exception\Invalid\InvalidDateException;
use Application\Exception\Invalid\InvalidHostSchemaException;
use Application\Exception\NotFound\RequestHeaderNotFoundException;
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
     *
     * @return Response
     */
    public function index() : Response
    {
        return new Response('Created by Zbigniew @Ferror Malcherczyk');
    }

    /**
     * @Route("/", methods={"POST"})
     *
     * @param Request $request
     *
     * @throws HoneyPotFoundException
     * @throws InvalidHostSchemaException
     * @throws InvalidDateException
     * @throws RequestHeaderNotFoundException
     *
     * @return Response
     */
    public function saveToJson(Request $request) : Response
    {
        $host = HostFactory::fromRequest($request);

        if (!$host->isSecure()) {
            throw new InvalidHostSchemaException('Host schema must me https');
        }

        if ($request->get('_gotcha')) {
            throw new HoneyPotFoundException();
        }

        if ($this->isOnWhitelist($host)) {
            $this->handle(new SavePostDataToJsonCommand(
                $host,
                $request->request->all(),
                $this->getParameter('kernel.project_dir') . '/data/content/'
            ));

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
     *
     */
    public function saveToMail(Request $request, string $uuid) : Response
    {

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom('test@example.com');
        $email->setSubject('Sending with SendGrid is Fun');
        $email->addTo($this->getParameter('sendgrid_email_address'));
        $email->addContent('text/html', '<strong>and easy to do anywhere, even with PHP</strong>');
        $response = $this->getSendGridMailer()->send($email);

        return new JsonResponse(
            [
                'data' => $request->request->all(),
                'mail_response' => $response->statusCode(),
                'host' => $request->getHost(),
                'env' => getenv('SENDER_EMAIL_ADDRESS'),
                'id' => $uuid,
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
