<?php

namespace Volcano\Logger;

class Logger
{
    private string $folderLog;

    public function __construct()
    {
        $this->folderLog = config()->path()->logs;
    }

    /**
     * @param string $log
     * @param string $message
     * @return bool
     */
    public function debug(string $log, string $message): bool
    {
        return $this->log($log, $message, LogLevel::DEBUG);
    }

    /**
     * @param string $log
     * @param string $message
     * @param LogLevel $level
     * @return bool
     */
    public function log(string $log, string $message, LogLevel $level): bool
    {
        if ($this->isLowerThan($level->value)) {
            return false;
        }

        $this->makeFolderIfNotExists($log);
        $this->writeLog($log, $message);

        return true;
    }

    /**
     * @param int $level
     * @return bool
     */
    private function isLowerThan(int $level): bool
    {
        return config()->get('BFST_LOG_LEVEL') < $level;
    }

    /**
     * @param string $log
     * @return void
     */
    private function makeFolderIfNotExists(string $log): void
    {
        $logFolder = dirname($log);
        $logPath = $this->folderLog . $logFolder;
        if (!file_exists($logPath)) {
            mkdir($logPath, 0777, true);
        }
    }

    /**
     * @param string $log
     * @param string $message
     * @return void
     */
    private function writeLog(string $log, string $message): void
    {
        $messageLog = sprintf(
            "[%s] %s\n",
            date('Y-m-d H:i:s'),
            $message
        );

        file_put_contents($this->folderLog . $log . '.log', $messageLog, FILE_APPEND);
    }

    /**
     * @param string $log
     * @param string $message
     * @return bool
     */
    public function critical(string $log, string $message): bool
    {
        return $this->log($log, $message, LogLevel::CRITICAL);
    }

    /**
     * @param string $log
     * @param string $message
     * @return bool
     */
    public function error(string $log, string $message): bool
    {
        return $this->log($log, $message, LogLevel::ERROR);
    }

    /**
     * @param string $log
     * @param string $message
     * @return bool
     */
    public function info(string $log, string $message): bool
    {
        return $this->log($log, $message, LogLevel::INFO);
    }

    /**
     * @param string $log
     * @param string $message
     * @return bool
     */
    public function warning(string $log, string $message): bool
    {
        return $this->log($log, $message, LogLevel::WARNING);
    }
}
