<?php
declare(strict_types=1);

namespace Application\Command;

use Application\Command;
use Application\Exception\Invalid\InvalidDateException;
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

    /**
     * @var string
     */
    private $jsonOutputDir;

    /**
     * @param Host $host
     * @param array $data
     * @param string $jsonOutputDir
     *
     * @throws InvalidDateException
     */
    public function __construct(Host $host, array $data, string $jsonOutputDir)
    {
        try {
            $this->date = new DateTime();
        } catch (\Exception $e) {
            throw new InvalidDateException((string) $this->date);
        }

        $this->host = $host;
        $this->data = $data;
        $this->jsonOutputDir = $jsonOutputDir;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function generateJsonFileName() : string
    {
        return sprintf(
            '%s%s_%s.json',
            $this->jsonOutputDir,
            $this->host->getName(),
            $this->date->format('Y_m_d_H_i_s')
        );
    }
}
