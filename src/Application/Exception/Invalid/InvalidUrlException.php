<?php
declare(strict_types=1);

namespace Application\Exception\Invalid;

final class InvalidUrlException extends \Exception
{
    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        parent::__construct("Invalid url: $url", 400);
    }
}
