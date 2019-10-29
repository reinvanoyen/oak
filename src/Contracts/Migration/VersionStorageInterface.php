<?php

namespace Oak\Contracts\Migration;

interface VersionStorageInterface
{
    public function get(): int;
    public function store(int $version);
}