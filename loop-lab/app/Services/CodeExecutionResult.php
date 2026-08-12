<?php

namespace App\Services;

readonly class CodeExecutionResult
{
    public function __construct(
        public bool $successful,
        public string $output,
        public string $error = '',
        public int $milliseconds = 0,
    ) {}
}
