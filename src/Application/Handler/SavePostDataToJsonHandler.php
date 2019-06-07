<?php
declare(strict_types=1);

namespace Application\Handler;

use Application\Command\SavePostDataToJsonCommand;

final class SavePostDataToJsonHandler
{
    public function handle(SavePostDataToJsonCommand $command) : void
    {
        $file = fopen($command->generateJsonFileName(), 'wb');
        fwrite($file, json_encode($command->getData()));
        fclose($file);
    }
}
