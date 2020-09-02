<?php

namespace Oak\Contracts\Database;

interface ConnectionInterface
{
    public function connect();
    public function disconnect();
}