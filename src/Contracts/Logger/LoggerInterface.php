<?php

namespace Oak\Contracts\Logger;

/**
 * Interface LoggerInterface
 * @package Oak\Contracts\Logger
 */
interface LoggerInterface
{
    /**
     * @param string $text
     */
    public function log(string $text);
}