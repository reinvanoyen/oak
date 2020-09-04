<?php

namespace Oak\Logger;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Logger\LoggerInterface;

/**
 * Class that writes logs to a file.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
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
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * FileLogger constructor.
     * @param string $filename
     * @param FilesystemInterface $filesystem
     */
    public function __construct(string $filename, FilesystemInterface $filesystem, RepositoryInterface $config)
    {
        $this->filename = $filename;
        $this->filesystem = $filesystem;
        $this->config = $config;
    }

    /**
     * @param string $text
     */
    public function log(string $text)
    {
        $this->filesystem->append($this->filename, date($this->config->get('logger.date_format', 'd/m/Y H:i')).' - '.$text."\n");
    }
}