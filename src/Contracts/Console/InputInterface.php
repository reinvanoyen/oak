<?php

namespace Oak\Contracts\Console;

use Oak\Console\Command\Signature;

/**
 * Interface InputInterface
 * @package Oak\Contracts\Console
 */
interface InputInterface
{
	public function setSignature(Signature $signature);
	public function getSignature(): Signature;

	public function validate();

	public function getArguments();
	public function getArgument(string $name);

	public function hasArgument(string $name): bool;
	public function setArgument(string $name, $value);

	public function getOptions();
	public function getOption(string $name);
	public function setOption(string $name, $value = true);

	public function hasSubCommand(): bool;
	public function getSubCommand();
	public function setSubCommand(string $name);
}