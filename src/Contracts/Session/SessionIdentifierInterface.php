<?php

namespace Oak\Contracts\Session;

/**
 * Interface SessionIdentifierInterface
 * @package app\session\contracts
 */
interface SessionIdentifierInterface
{
    /**
     * @param int $length
     * @return string
     */
    public function generate(int $length): string;
}