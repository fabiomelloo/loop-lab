<?php

namespace Tests\Unit;

use App\Services\RestrictedPhpRunner;
use Tests\TestCase;

class RestrictedPhpRunnerTest extends TestCase
{
    public function test_it_normalizes_a_successful_process_result(): void
    {
        $result = app(RestrictedPhpRunner::class)->run('<?php echo "Olá";');

        $this->assertTrue($result->successful);
        $this->assertSame('Olá', $result->output);
    }

    public function test_it_stops_an_infinite_loop(): void
    {
        $result = app(RestrictedPhpRunner::class)->run('<?php while (true) {}');

        $this->assertFalse($result->successful);
        $this->assertStringContainsString('Tempo excedido', $result->error);
    }
}
