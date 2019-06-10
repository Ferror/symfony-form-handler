<?php
declare(strict_types=1);

namespace Infrastructure\SendGrid;

use Application\Exception\SendGridMailerException;
use SendGrid;
use SendGrid\Mail\Mail;

final class SendGridMailer
{
    /**
     * @var SendGrid
     */
    private $mailer;

    /**
     * @param string $apikey
     */
    public function __construct(string $apikey)
    {
        $this->mailer = new SendGrid($apikey);
    }

    /**
     * @param Mail $mail
     * @throws SendGridMailerException
     */
    public function send(Mail $mail) : void
    {
        $response = $this->mailer->send($mail);

        if ($response->statusCode() !== 202) {
            throw new SendGridMailerException($response->body(), $response->statusCode());
        }
    }
}
