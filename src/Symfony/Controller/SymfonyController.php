<?php
declare(strict_types=1);

namespace Symfony\Controller;

use Application\Command;
use Infrastructure\SendGrid\SendGridMailer;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class SymfonyController extends AbstractController
{
    private $mailer;
    private $commandBus;
    private $sendGridMailer;

    public function __construct(\Swift_Mailer $mailer, CommandBus $commandBus, SendGridMailer $sendGridMailer)
    {
        $this->mailer = $mailer;
        $this->commandBus = $commandBus;
        $this->sendGridMailer = $sendGridMailer;
    }

    public function getSwiftMailer() : \Swift_Mailer
    {
        return $this->mailer;
    }

    public function getSendGridMailer() : SendGridMailer
    {
        return $this->sendGridMailer;
    }

    public function handle(Command $command) : void
    {
        $this->commandBus->handle($command);
    }
}
