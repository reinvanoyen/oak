<?php

namespace Oak\Logger\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class Logger extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('logger')
            ->addSubCommand(View::class)
            ->addSubCommand(Log::class)
        ;
    }
}