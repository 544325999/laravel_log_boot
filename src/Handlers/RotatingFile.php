<?php
/**
 * rotatingFile
 */

namespace MasterKong\Boot\Handlers;

use Monolog\Handler\BufferHandler;
use Monolog\Handler\RotatingFileHandler;

class RotatingFile extends AbstractHandler
{
    /**
     * get the handler
     *
     * @param string $level
     */
    public function getHandler($level)
    {
        return new BufferHandler(
            (new RotatingFileHandler(
                $this->getLogPath(),
                $this->getMaxFiles(),
                $this->parseLevel($level),
                true,
                0644
            ))
            ->setFormatter($this->getDefaultFormatter())
        );
    }
}
