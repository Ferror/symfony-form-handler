<?php
declare(strict_types=1);

namespace Application\Command;

use Application\Command;
use DateTime;
use Domain\Host;

final class SavePostDataToJsonCommand implements Command
{
    /**
     * @var Host
     */
    private $host;

    /**
     * @var array
     */
    private $data;

    /**
     * @var DateTime
     */
    private $date;

    public function __construct(Host $host, array $data)
    {
        $this->host = $host;
        $this->data = $data;
        $this->date = new DateTime();
    }

    public function getDate() : DateTime
    {
        return $this->date;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function getHostName() : string
    {
        return (string) $this->host;
    }
}
