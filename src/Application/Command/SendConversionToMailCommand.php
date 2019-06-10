<?php
declare(strict_types=1);

namespace Application\Command;

use Application\Command;
use Domain\Host;
use SendGrid\Mail\From;
use SendGrid\Mail\HtmlContent;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Subject;
use SendGrid\Mail\To;

final class SendConversionToMailCommand implements Command
{
    /**
     * @var Host
     */
    private $host;

    /**
     * @var array
     */
    private $data;
    
    /**
     * @var string
     */
    private $receiver;

    /**
     * @param Host $host
     * @param array $data
     * @param string $receiver
     */
    public function __construct(Host $host, array $data, string $receiver)
    {
        $this->host = $host;
        $this->data = $data;
        $this->receiver = $receiver;
    }

    public function getMail() : Mail
    {
        return new Mail(
            new From('mail@malcherczyk.com'),
            new To($this->receiver),
            new Subject(sprintf('Conversion from: %s', $this->host->getName())),
            null,
            new HtmlContent('<strong>and easy to do anywhere, even with PHP</strong>')
        );
    }
}
