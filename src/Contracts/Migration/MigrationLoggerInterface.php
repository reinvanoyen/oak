<?php

namespace Oak\Contracts\Migration;

interface MigrationLoggerInterface
{
    /**
     * @param RevisionInterface $revision
     * @return mixed
     */
    public function logUpdate(RevisionInterface $revision);

    /**
     * @param RevisionInterface $revision
     * @return mixed
     */
    public function logDowndate(RevisionInterface $revision);
}