<?php

namespace Oak\Contracts\Console;

/**
 * Interface OutputInterface
 * @package Oak\Contracts\Console
 */
interface OutputInterface
{
	const TYPE_PLAIN = 0;
	const TYPE_INFO = 1;
	const TYPE_WARNING = 2;
	const TYPE_ERROR = 3;

	public function writeLine(string $message, int $type = self::TYPE_PLAIN);
	public function write(string $message, int $type = self::TYPE_PLAIN);
	public function newline();
}