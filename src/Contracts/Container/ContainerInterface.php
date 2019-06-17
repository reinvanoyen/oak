<?php

namespace Oak\Contracts\Container;

interface ContainerInterface
{
	public function set(string $contract, $mixed);
	public function get(string $contract);
	public function has(string $contract): bool;
}