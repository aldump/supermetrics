<?php

declare(strict_types=1);

namespace App\Aggregator;

class AvgLength
{
    /**
     * @phpcs:ignore SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @param array<mixed> $data
     */
    public function process(array $data, callable $callback): float | int
    {
        $length = 0;
        $count = 0;

        foreach ($data as $datum) {
            $length += strlen($callback($datum));
            $count++;
        }

        return $length / max($count, 1);
    }
}
