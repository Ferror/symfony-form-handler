<?php
declare(strict_types=1);

namespace Application\Exception;

final class SendGridMailerException extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct("Could not send mail, because: $message", $code);
    }
}
