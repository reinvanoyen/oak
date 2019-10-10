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
     * @var array $rawArguments
     */
    private $rawArguments = [];

    /**
     * @var array $missingArguments
     */
    private $missingArguments = [];

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
     *
     */
    private function reset()
    {
        $this->subCommand = [];
        $this->arguments = [];
        $this->missingArguments = [];
    }

    /**
     *
     */
    private function parse()
    {
        if (! $this->rawArguments) {
            $this->rawArguments = $GLOBALS['argv'];
        }

        array_shift($this->rawArguments);

        // First we check if any subcommand was requested
        if (isset($this->rawArguments[0])) {
            foreach ($this->getSignature()->getSubCommands() as $command) {
                if ($this->rawArguments[0] === $command->getName()) {
                    $this->setSubCommand($command->getName());
                    break;
                }
            }
        }

        // First we parse out the options
        foreach ($this->getSignature()->getOptions() as $option) {
            $definitions = [
                '-'.$option->getName(),
                '--'.$option->getName(),
            ];

            if ($option->getAlias()) {
                $definitions[] = '-'.$option->getAlias();
                $definitions[] = '--'.$option->getAlias();
            }

            foreach ($definitions as $definition) {
                $optionPosition = array_search($definition, $this->rawArguments);
                if ($optionPosition !== false) {
                    array_splice($this->rawArguments, $optionPosition, 1);
                    $this->setOption($option->getName());
                    break;
                }
            }
        }

        // Now we loop all arguments and me sure they are present
        foreach ($this->getSignature()->getArguments() as $position => $argument) {
            if (isset($this->rawArguments[$position])) {
                $this->setArgument($argument->getName(), $this->rawArguments[$position]);
            } else {
                $this->missingArguments[] = $argument->getName();
            }
        }
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