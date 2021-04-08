<?php

declare(strict_types=1);

namespace App\Tests;

use App\Aggregator\AvgLength;
use PHPUnit\Framework\TestCase;

class AvgLengthTest extends TestCase
{
    public function testProcessCorrect(): void
    {
        $aggregator = new AvgLength();

        self::assertSame(1, $aggregator->process(['1', '2', '3'], fn($item) => $item));
    }
}
