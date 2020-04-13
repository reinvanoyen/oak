<?php

namespace Rein\Http\Routing\Contracts;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface RouterInterface
{
    public function dispatch(Request $request): Response;
}