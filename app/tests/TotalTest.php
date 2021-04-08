<?php

declare(strict_types=1);

namespace App\Tests;

use App\Aggregator\Total;
use PHPUnit\Framework\TestCase;

class TotalTest extends TestCase
{
    public function testProcessCorrect(): void
    {
        $aggregator = new Total();

        self::assertSame(3, $aggregator->process(['1', '2', '3']));
    }
}
