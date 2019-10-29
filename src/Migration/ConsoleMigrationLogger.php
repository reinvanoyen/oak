<?php

namespace Hector\Migration;

use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Migration\MigrationLoggerInterface;
use Oak\Contracts\Migration\RevisionInterface;

class ConsoleMigrationLogger implements MigrationLoggerInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function logUpdate(RevisionInterface $revision)
    {
        $this->output->writeLine($revision->describeUp());
    }

    public function logDowndate(RevisionInterface $revision)
    {
        $this->output->writeLine($revision->describeDown());
    }
}