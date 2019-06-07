<?php
declare(strict_types=1);

namespace Application\Exception\NotFound;

final class FileNotFoundException extends \Exception
{
    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct("File $fileName not exists", 404);
    }
}
