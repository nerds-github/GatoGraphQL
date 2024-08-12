<?php

declare(strict_types=1);

namespace GatoGraphQL\GatoGraphQL\Log;

use GatoGraphQL\GatoGraphQL\PluginEnvironment;

class Logger implements LoggerInterface
{
    public function logError(string $message): void
    {
        \error_log(sprintf(
            '[Gato GraphQL] %s',
            $message
        ));
    }

    /**
     * @see https://stackoverflow.com/a/7655379
     */
    public function logInfo(string $message): void
    {
        $logFile = PluginEnvironment::getLogsFilePath('info.log');
        if (!file_exists($logFile)) {
            $handle = fopen($logFile, "w");
            if ($handle === false) {
                $this->logError('Can\'t create log file under path ' . $logFile);
                return;
            }
            fclose($handle);
        }
        \error_log(sprintf(
            '[Gato GraphQL] %s',
            $message
        ), 3, $logFile);
    }
}
