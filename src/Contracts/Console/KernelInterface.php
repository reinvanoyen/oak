<?php

namespace Oak\Contracts\Console;

/**
 * Interface KernerInterface
 * @package Oak\Contracts\Console
 */
interface KernelInterface
{
	public function handle(InputInterface $input, OutputInterface $output);
}