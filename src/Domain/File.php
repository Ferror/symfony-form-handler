<?php
declare(strict_types=1);

namespace Domain;

final class File
{
    /**
     * @var string
     */
    private $content;

    public function __construct(string $path)
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new \Exception('File not found exception');
        }

        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function toArray()
    {
        return json_decode($this->content, true);
    }
}
