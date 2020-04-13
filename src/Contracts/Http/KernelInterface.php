<?php

namespace Oak\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

interface KernelInterface
{
    public function handle(ServerRequestInterface $request);
}