<?php

namespace Oak\Logger;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Logger\LoggerInterface;

/**
 * Class FileLogger
 * @package Oak\Logger
 */
class FileLogger implements LoggerInterface
{
	/**
	 * @var string $filename
	 */
	private $filename;

	/**
	 * @var FilesystemInterface $filesystem
	 */
	private $filesystem;

	/**
	 * FileLogger constructor.
	 * @param string $filename
	 * @param FilesystemInterface $filesystem
	 */
	public function __construct(string $filename, FilesystemInterface $filesystem)
	{
		$this->filename = $filename;
		$this->filesystem = $filesystem;
	}

	/**
	 * @param string $text
	 */
	public function log(string $text)
	{
		$this->filesystem->append($this->filename, date('d/m/Y H:i').' - '.$text."\n");
	}
}