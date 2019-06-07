<?php
declare(strict_types=1);

namespace Domain;

use Application\Exception\Invalid\InvalidUrlException;
use Domain\Address\Url;

final class Host
{
    /**
     * @var string
     */
    private $schema;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $schema
     * @param string $name
     */
    public function __construct(string $schema, string $name)
    {
        $this->schema = $schema;
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isSecure() : bool
    {
        return $this->schema === 'https';
    }

    /**
     * @throws InvalidUrlException
     *
     * @return Url
     */
    public function getUrl() : Url
    {
        return new Url(sprintf('%s://%s', $this->schema, $this->name));
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
