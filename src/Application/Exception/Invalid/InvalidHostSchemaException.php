<?php
declare(strict_types=1);

namespace Application\Exception\Invalid;

final class InvalidHostSchemaException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
