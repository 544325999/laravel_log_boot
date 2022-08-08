<?php
/**
 * log 处理抽象类
 */

namespace MasterKong\Boot\Handlers;

use Monolog\Logger;
use InvalidArgumentException;
use Monolog\Formatter\LineFormatter;

abstract class AbstractHandler
{
    /**
    * The Log levels.
    *
    * @var array
    */
    protected $levels = [
        'debug'     => Logger::DEBUG,
        'info'      => Logger::INFO,
        'notice'    => Logger::NOTICE,
        'warning'   => Logger::WARNING,
        'error'     => Logger::ERROR,
        'critical'  => Logger::CRITICAL,
        'alert'     => Logger::ALERT,
        'emergency' => Logger::EMERGENCY,
    ];

    /**
     *
     *
     * @param string $level
     */
    abstract public function getHandler($level);

    /**
    * Parse the string level into a Monolog constant.
    *
    * @param  string  $level
    * @return int
    *
    * @throws \InvalidArgumentException
    */
    protected function parseLevel($level)
    {
        if (isset($this->levels[$level])) {
            return $this->levels[$level];
        }

        throw new InvalidArgumentException('Invalid log level.');
    }

    /**
     * Get a default Monolog formatter instance.
     *
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function getDefaultFormatter()
    {
        return tap(new LineFormatter(null, null, true, true), function ($formatter) {
            $formatter->includeStacktraces();
        });
    }

    /**
     * Get log path
     */
    protected function getLogPath()
    {
        return config('log_boot.path', storage_path('logs/log_file.log'));
    }

    /**
     * Get the maximum number of log files for the application.
     *
     * @return int
     */
    protected function getMaxFiles()
    {
        return env('MAX_FILES', 90);
    }
}
