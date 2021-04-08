<?php

declare(strict_types=1);

namespace App\Tests;

use App\Aggregator\AvgTotal;
use PHPUnit\Framework\TestCase;

class AvgTotalTest extends TestCase
{
    public function testProcessCorrect(): void
    {
        $aggregator = new AvgTotal();
        $data = [
            '1' => ['1', '2'],
            '2' => [1],
            '3' => [],
        ];

        self::assertSame(1, $aggregator->process($data));
    }
}
