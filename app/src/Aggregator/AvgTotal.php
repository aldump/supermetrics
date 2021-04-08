<?php

declare(strict_types=1);

namespace App\Aggregator;

class AvgTotal
{
    /**
     * @phpcs:ignore SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @param array<mixed> $data
     */
    public function process(array $data): float | int
    {
        $length = 0;
        $count = 0;
        $totalAgg = new Total();

        foreach ($data as $datum) {
            $length += $totalAgg->process($datum);
            $count++;
        }

        return $length / max($count, 1);
    }
}
