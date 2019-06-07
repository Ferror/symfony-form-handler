<?php
declare(strict_types=1);

namespace Application\Exception\Invalid;

final class InvalidDateException extends \Exception
{
    /**
     * @param string $date
     */
    public function __construct(string $date)
    {
        parent::__construct("Invalid date: $date", 400);
    }
}
