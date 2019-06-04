<?php
declare(strict_types=1);

namespace Domain\Address;

final class Url
{
    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid url');
        }

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->url;
    }
}
