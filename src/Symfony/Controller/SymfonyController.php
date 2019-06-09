<?php
declare(strict_types=1);

namespace Symfony\Controller;

use Application\Command;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class SymfonyController extends AbstractController
{
    private $mailer;
    private $commandBus;

    public function __construct(\Swift_Mailer $mailer, CommandBus $commandBus)
    {
        $this->mailer = $mailer;
        $this->commandBus = $commandBus;
    }

    public function getSwiftMailer() : \Swift_Mailer
    {
        return $this->mailer;
    }

    public function getSendGridMailer() : \SendGrid
    {
        return new \SendGrid(getenv('SENDGRID_API_KEY'));
    }

    public function handle(Command $command) : void
    {
        $this->commandBus->handle($command);
    }
}
