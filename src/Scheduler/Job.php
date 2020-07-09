<?php

namespace Oak\Scheduler;

use Oak\Contracts\Scheduler\JobInterface;

class Job implements JobInterface
{
    use CrontabExpressionTrait;

    /**
     * @var string $command
     */
    private $command;

    /**
     * Job constructor.
     * @param string $command
     */
    public function __construct(string $command)
    {
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function execute(): string
    {
        return shell_exec($this->command);
    }
}