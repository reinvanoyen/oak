<?php

namespace Oak\Migration\Logger;

use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\RevisionInterface;

class ConsoleMigrationLogger implements MigrationLoggerInterface
{
    /**
     * @var OutputInterface $output
     */
    private $output;

    /**
     * ConsoleMigrationLogger constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param RevisionInterface $revision
     */
    public function logUpdate(RevisionInterface $revision)
    {
        $this->output->writeLine($revision->describeUp());
    }

    /**
     * @param RevisionInterface $revision
     */
    public function logDowndate(RevisionInterface $revision)
    {
        $this->output->writeLine($revision->describeDown());
    }
}