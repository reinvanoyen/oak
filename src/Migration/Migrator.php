<?php

namespace Oak\Migration;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\RevisionInterface;
use Oak\Contracts\Migration\VersionStorageInterface;

class Migrator
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * Handles storing the version
     *
     * @var VersionStorageInterface
     */
    private $versionStorage;

    /**
     * Handles logging the revision descriptions
     *
     * @var MigrationLoggerInterface
     */
    private $migrationLogger;

    /**
     * Array holding all revisions
     *
     * @var array RevisionInterface[]
     */
    private $revisions = [];

    /**
     * The maximum version number
     *
     * @var int
     */
    private $maxVersion = 0;

    /**
     * Migrator constructor.
     * @param VersionStorageInterface $versionStorage
     * @param MigrationLoggerInterface|null $migrationLogger
     */
    public function __construct(string $name, VersionStorageInterface $versionStorage, MigrationLoggerInterface $migrationLogger, ContainerInterface $app)
    {
        $this->name = $name;
        $this->versionStorage = $versionStorage;
        $this->migrationLogger = $migrationLogger;
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Adds a revision to the migrator
     *
     * @param RevisionInterface $revision
     */
    public function addRevision(RevisionInterface $revision): void
    {
        $this->revisions[] = $revision;
        $this->maxVersion++;
    }

    /**
     * Sets the revisions
     *
     * @param array $revisions
     */
    public function setRevisions(array $revisions): void
    {
        $this->revisions = $revisions;
        $this->maxVersion = count($this->revisions);
    }

    /**
     * Migrate all revisions
     *
     */
    public function migrate()
    {
        $this->rollTo($this->maxVersion);
    }

    /**
     * Updates to the next revision
     *
     */
    public function update()
    {
        $nextVersionNumber = $this->getClampedVersion($this->versionStorage->get($this)+1);
        $nextRevision = $this->getRevisionByVersion($nextVersionNumber);

        if (! $nextRevision || $this->isUpToDateWith($nextVersionNumber)) {
            return;
        }

        $nextRevision->up();

        $this->migrationLogger->logUpdate($nextRevision);
        $this->versionStorage->store($this, $nextVersionNumber);
    }

    /**
     * Rolls back one version
     *
     */
    public function downdate()
    {
        $revision = $this->getCurrentRevision();

        if (! $revision) {
            return;
        }

        $revision->down();

        $this->migrationLogger->logDowndate($revision);

        $version = $this->getClampedVersion($this->versionStorage->get($this)-1);
        $this->versionStorage->store($this, $version);
    }

    /**
     * Undoes all revisions
     *
     */
    public function reset()
    {
        $this->rollTo(0);
    }

    /**
     * Rolls to a specific version
     *
     * @param int $version
     */
    public function rollTo(int $version)
    {
        // Clamp the version number
        $version = max(min($version, $this->maxVersion), 0);

        // Check whether we are already up-to-date with the requested version
        if ($this->isUpToDateWith($version)) {
            return;
        }

        $currentVersion = $this->versionStorage->get($this);

        // Check whether we need to downdate
        if ($currentVersion > $version) {
            $this->downdate();
        }

        // Check whether we need to update
        if ($currentVersion < $version) {
            $this->update();
        }

        $this->rollTo($version);
        return;
    }

    /**
     * Gets the current version
     *
     * @return int
     */
    public function getVersion(): int
    {
        return $this->versionStorage->get($this);
    }

    /**
     * Gets the maximum version
     *
     * @return int
     */
    public function getMaxVersion(): int
    {
        return $this->maxVersion;
    }

    /**
     * Check if we're up-to-date with the current version
     *
     * @param int $version
     * @return bool
     */
    private function isUpToDateWith(int $version): bool
    {
        return ($this->versionStorage->get($this) === $version);
    }

    /**
     * @param int $version
     * @return int
     */
    private function getClampedVersion(int $version): int
    {
        return max(min($version, $this->maxVersion), 0);
    }

    /**
     * Get a revision by a specific version number
     *
     * @param int $version
     * @return RevisionInterface|null
     */
    private function getRevisionByVersion(int $version): ?RevisionInterface
    {
        $version = $this->getClampedVersion($version);

        if (isset($this->revisions[$version-1])) {

            if (is_string($this->revisions[$version-1])) {
                return $this->app->get($this->revisions[$version-1]);
            }

            return $this->revisions[$version-1];
        }

        return null;
    }

    /**
     * Gets the current revision
     *
     * @return RevisionInterface|null
     */
    private function getCurrentRevision(): ?RevisionInterface
    {
        return $this->getRevisionByVersion($this->versionStorage->get($this));
    }
}