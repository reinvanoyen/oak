<?php

namespace Hector\Migration;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Migration\VersionStorageInterface;

class FileVersionStorage implements VersionStorageInterface
{
    /**
     * Handles working with files
     *
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Filename of the file that stores the version number
     *
     * @var string
     */
    private $filename;

    /**
     * FileVersionStorage constructor.
     * @param FilesystemInterface $filesystem
     * @param string $filename
     */
    public function __construct(FilesystemInterface $filesystem, string $filename)
    {
        $this->filesystem = $filesystem;
        $this->filename = $filename;
    }

    /**
     * Store the version to the file
     *
     * @param int $version
     */
    public function store(int $version)
    {
        $this->filesystem->put($this->filename, $version);
    }

    /**
     * Get the version number from the file
     *
     * @return int
     */
    public function get(): int
    {
        return (int) $this->filesystem->get($this->filename);
    }
}