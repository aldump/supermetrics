<?php

declare(strict_types=1);

namespace App\Aggregator;

class Total
{
    /**
     * @phpcs:ignore SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @param array<mixed> $data
     */
    public function process(array $data): int
    {
        return count($data);
    }
}
