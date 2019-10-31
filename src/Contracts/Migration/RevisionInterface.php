<?php

namespace Oak\Contracts\Migration;

interface RevisionInterface
{
    public function up();
    public function down();
    public function describeUp(): string;
    public function describeDown(): string;
}