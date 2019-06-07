<?php
declare(strict_types=1);

namespace Application\Exception\Invalid;

final class InvalidJsonFileException extends \Exception
{
    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct("Could not decode file: $path", 400);
    }
}
