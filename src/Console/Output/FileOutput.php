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
     * @var string $filename
     */
    private $filename;

    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * FileOutput constructor.
     * @param FilesystemInterface $filesystem
     */
    public function __construct(string $filename, FilesystemInterface $filesystem)
    {
        $this->filename = $filename;
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $message
     * @param int $type
     */
    public function writeLine(string $message, int $type = self::TYPE_PLAIN)
    {
        $this->filesystem->append($this->filename, $message."\n");
    }

    /**
     * @param string $message
     * @param int $type
     */
    public function write(string $message, int $type = self::TYPE_PLAIN)
    {
        $this->filesystem->append($this->filename, $message);
    }

    /**
     *
     */
    public function newline()
    {
        $this->filesystem->append($this->filename, "\n");
    }
}