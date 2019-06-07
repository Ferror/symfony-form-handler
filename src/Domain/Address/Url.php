<?php
declare(strict_types=1);

namespace Domain\Address;

use Application\Exception\Invalid\InvalidUrlException;

final class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     *
     * @throws InvalidUrlException
     */
    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException($url);
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
