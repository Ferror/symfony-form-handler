<?php
declare(strict_types=1);

namespace Domain;

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

    public function __construct(string $schema, string $name)
    {
        $this->schema = $schema;
        $this->name = $name;
    }

    public function isSecure() : bool
    {
        return $this->schema === 'https';
    }

    public function getUrl() : Url
    {
        return new Url(sprintf('%s://%s', $this->schema, $this->name));
    }

    public function __toString()
    {
        return $this->name;
    }
}
