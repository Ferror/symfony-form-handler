<?php
declare(strict_types=1);

namespace Application\Exception;

final class HoneyPotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('It seems like... you are a bot.', 400);
    }
}
