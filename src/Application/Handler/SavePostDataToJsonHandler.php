<?php
declare(strict_types=1);

namespace Application\Handler;

use Application\Command\SavePostDataToJsonCommand;

final class SavePostDataToJsonHandler
{
    public function handle(SavePostDataToJsonCommand $command) : void
    {
        $name = sprintf('%s_%s.json', $command->getHostName(), $command->getDate()->format('Y_m_d_H_i_s'));
        //$this->getParameter('kernel.project_dir') jako parametr
        $file = fopen($command->getJsonOutputDir() . $name, 'wb');
        fwrite($file, json_encode($command->getData()));
        fclose($file);
    }
}
