<?php

namespace Oak\Migration\Storage;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Migration\VersionStorageInterface;
use Oak\Migration\Migrator;

/**
 * Class that writes/reads the migration version to/from a file.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class FileVersionStorage implements VersionStorageInterface
{
    /**
     * Handles working with files
     *
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Path to the file that stores the version number
     *
     * @var string
     */
    private $path;

    /**
     * FileVersionStorage constructor.
     * @param FilesystemInterface $filesystem
     * @param string $path
     */
    public function __construct(FilesystemInterface $filesystem, string $path)
    {
        $this->filesystem = $filesystem;
        $this->path = $path;
    }

    /**
     * @param Migrator $migrator
     * @param int $version
     */
    public function store(Migrator $migrator, int $version)
    {
        $this->filesystem->put($this->path.$migrator->getName().'.txt', $version);
    }

    /**
     * @param Migrator $migrator
     * @return int
     */
    public function get(Migrator $migrator): int
    {
        return (int) $this->filesystem->get($this->path.$migrator->getName().'.txt');
    }
}