<?php

namespace Oak\Migration\Storage;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Migration\VersionStorageInterface;
use Oak\Migration\Migrator;

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
     * @param Migrator $migrator
     * @param int $version
     */
    public function store(Migrator $migrator, int $version)
    {
        $this->filesystem->put($this->filename, $version);
    }

    /**
     * @param Migrator $migrator
     * @return int
     */
    public function get(Migrator $migrator): int
    {
        return (int) $this->filesystem->get($this->filename);
    }
}