<?php

namespace Rein\Http\Contracts;

use Symfony\Component\HttpFoundation\Request;

interface KernelInterface
{
    public function handle(Request $request);
}