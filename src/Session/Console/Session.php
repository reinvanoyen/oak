<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class Session extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('session')
            ->addSubCommand(Status::class)
            ->addSubCommand(GarbageCollect::class)
            ->addSubCommand(ClearAll::class)
        ;
    }
}