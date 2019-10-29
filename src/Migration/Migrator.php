<?php

namespace Oak\Migration;

use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\RevisionInterface;
use Oak\Contracts\Migration\VersionStorageInterface;

class Migrator
{
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
     *
     * @param VersionStorageInterface $versionStore
     */
    public function __construct(VersionStorageInterface $versionStorage, MigrationLoggerInterface $migrationLogger = null)
    {
        $this->versionStorage = $versionStorage;

        if ($migrationLogger) {
            $this->migrationLogger = $migrationLogger;
        }
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
        $nextVersionNumber = $this->getClampedVersion($this->versionStorage->get()+1);
        $nextRevision = $this->getRevisionByVersion($nextVersionNumber);

        if (! $nextRevision || $this->isUpToDateWith($nextVersionNumber)) {
            return;
        }

        $nextRevision->up();

        if ($this->migrationLogger) {
            $this->migrationLogger->logUpdate($nextRevision);
        }

        $this->versionStorage->store($nextVersionNumber);
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

        if ($this->migrationLogger) {
            $this->migrationLogger->logDowndate($revision);
        }

        $version = $this->getClampedVersion($this->versionStorage->get()-1);
        $this->versionStorage->store($version);
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

        $currentVersion = $this->versionStorage->get();

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
        return $this->versionStorage->get();
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
        return ($this->versionStorage->get() === $version);
    }

    /**
     * Check if we're up to date with the latest revision
     *
     * @return bool
     */
    private function isUpToDate() : bool
    {
        return $this->isUpToDateWith($this->maxVersion);
    }

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
        return $this->getRevisionByVersion($this->versionStorage->get());
    }
}