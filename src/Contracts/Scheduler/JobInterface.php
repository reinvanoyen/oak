<?php

namespace Oak\Contracts\Scheduler;

interface JobInterface
{
    /**
     * @return string
     */
    public function getCronExpression(): string;

    /**
     * @return string
     */
    public function getCommand(): string;

    /**
     * @return string
     */
    public function execute(): string;
}