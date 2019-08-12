<?php

namespace Oak\Console\Output;

use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

/**
 * Class FileOutput
 * @package Oak\Console\Output
 */
class FileOutput implements OutputInterface
{
	/**
	 * @var FilesystemInterface $filesystem
	 */
	private $filesystem;

	/**
	 * FileOutput constructor.
	 * @param FilesystemInterface $filesystem
	 */
	public function __construct(FilesystemInterface $filesystem)
	{
		$this->filesystem = $filesystem;
	}

	/**
	 * @param string $message
	 * @param int $type
	 */
	public function writeLine(string $message, int $type = self::TYPE_PLAIN)
	{
		$this->filesystem->append('haha.txt', $message."\n");
	}

	/**
	 * @param string $message
	 * @param int $type
	 */
	public function write(string $message, int $type = self::TYPE_PLAIN)
	{
		$this->filesystem->append('haha.txt', $message);
	}

	/**
	 *
	 */
	public function newline()
	{
		$this->filesystem->append('haha.txt', "\n"); // @TODO make filename a property
	}
}