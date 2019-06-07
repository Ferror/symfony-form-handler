<?php
declare(strict_types=1);

namespace Application\Exception\NotFound;

final class RequestHeaderNotFoundException extends \Exception
{
    /**
     * @param string $header
     */
    public function __construct(string $header)
    {
        parent::__construct("Header $header not found in request", 400);
    }
}
