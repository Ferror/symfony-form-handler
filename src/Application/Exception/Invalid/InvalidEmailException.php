<?php
declare(strict_types=1);

namespace Application\Exception\Invalid;

final class InvalidEmailException extends \Exception
{
    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        parent::__construct("Invalid email: $email", 400);
    }
}
