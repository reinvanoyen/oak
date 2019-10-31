<?php

namespace Oak\Contracts\Migration;

use Oak\Migration\Migrator;

interface VersionStorageInterface
{
    public function get(Migrator $migrator): int;
    public function store(Migrator $migrator, int $version);
}