<?php

namespace Oak\Migration\Storage;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Migration\VersionStorageInterface;
use Oak\Migration\Migrator;

class JsonVersionStorage implements VersionStorageInterface
{
    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * @var string $filename
     */
    private $filename;

    /**
     * JsonVersionStorage constructor.
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem, string $filename)
    {
        $this->filesystem = $filesystem;
        $this->filename = $filename;
    }

    /**
     * @param Migrator $migrator
     * @return int
     */
    public function get(Migrator $migrator): int
    {
        if (! $this->filesystem->exists($this->filename)) {
            $this->filesystem->put($this->filename, '{}');
        }

        $versionData = json_decode($this->filesystem->get($this->filename), true);

        return $versionData[$migrator->getName()] ?? 0;
    }

    /**
     * @param Migrator $migrator
     * @param int $version
     */
    public function store(Migrator $migrator, int $version)
    {
        $versionData = json_decode($this->filesystem->get($this->filename), true);
        $versionData[$migrator->getName()] = $version;

        $this->filesystem->put($this->filename, json_encode($versionData));
    }
}