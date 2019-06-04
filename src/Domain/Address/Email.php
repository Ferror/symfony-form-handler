<?php
declare(strict_types=1);

namespace Domain\Address;

use Application\Exception\InvalidEmailException;

final class Email
{
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("Invalid email: $email");
        }

        $this->email = $email;
    }

    public function __toString() : string
    {
        return $this->email;
    }
}
