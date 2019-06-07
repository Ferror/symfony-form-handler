<?php
declare(strict_types=1);

namespace Domain;

use Application\Exception\Invalid\InvalidJsonFileException;
use Application\Exception\NotFound\FileNotFoundException;

final class File
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     *
     * @throws FileNotFoundException
     */
    public function __construct(string $path)
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new FileNotFoundException('File not found exception');
        }

        $this->content = $content;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @throws InvalidJsonFileException
     *
     * @return array
     */
    public function toArray() : array
    {
        $decoded = json_decode($this->content, true);

        if ($decoded === null) {
            throw new InvalidJsonFileException($this->path);
        }

        return $decoded;
    }
}
