<?php

declare(strict_types=1);

namespace App\Tests;

use App\Aggregator\Longest;
use PHPUnit\Framework\TestCase;

class LongestTest extends TestCase
{
    public function testProcessCorrect(): void
    {
        $aggregator = new Longest();

        self::assertSame('12', $aggregator->process(['12', '2', '3'], fn($item) => $item));
    }
}
