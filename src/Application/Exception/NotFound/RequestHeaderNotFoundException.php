<?php
declare(strict_types=1);

namespace Application\Exception\NotFound;

final class RequestHeaderNotFoundException extends \Exception
{
    public function __construct($header)
    {
        parent::__construct("Header $header not found in request", 404);
    }
}
