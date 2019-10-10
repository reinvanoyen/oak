<?php

namespace Oak\Config\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class Config extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('config')
            ->addSubCommand(Cache::class)
            ->addSubCommand(ClearCache::class)
        ;
    }
}