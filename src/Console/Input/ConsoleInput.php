<?php

namespace Oak\Console\Input;

use Oak\Console\Command\Signature;
use Oak\Console\Exception\InvalidArgumentException;

/**
 * Class ConsoleInput
 * @package Oak\Console\Input
 */
class ConsoleInput extends Input
{
    /**
     * @param Signature $signature
     */
    public function setSignature(Signature $signature)
    {
        parent::setSignature($signature);
        $this->reset();
        $this->parse();
    }

    /**
     * Reset the state of the input
     */
    private function reset()
    {
        $this->subCommand = [];
        $this->arguments = [];
        $this->missingArguments = [];
    }

    /**
     * Parse the input from the argv globals
     */
    private function parse()
    {
        if (! $this->rawArguments) {
            $this->rawArguments = $GLOBALS['argv'];
        }

        array_shift($this->rawArguments);

        $this->parseRawArguments();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate()
    {
        if (count($this->missingArguments)) {
            throw new InvalidArgumentException('Missing argument(s) '.implode(', ', $this->missingArguments));
        }
    }
}