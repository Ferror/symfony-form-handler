<?php
declare(strict_types=1);

namespace Application\Handler;

use Application\Command\SendConversionToMailCommand;
use Application\Exception\SendGridMailerException;
use Infrastructure\SendGrid\SendGridMailer;

final class SendConversionToMailHandler
{
    /**
     * @var SendGridMailer
     */
    private $mailer;

    /**
     * @param SendGridMailer $mailer
     */
    public function __construct(SendGridMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param SendConversionToMailCommand $command
     * @throws SendGridMailerException
     */
    public function handle(SendConversionToMailCommand $command) : void
    {
        $this->mailer->send($command->getMail());
    }
}
