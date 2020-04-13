<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class Filesystem extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('filesystem')
            ->addSubCommand(Directories::class)
            ->addSubCommand(Files::class)
        ;
    }
}