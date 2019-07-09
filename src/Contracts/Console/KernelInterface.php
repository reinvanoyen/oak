<?php

namespace Oak\Contracts\Console;

interface KernerInterface
{
	public function handle(InputInterface $input, OutputInterface $output);
}