<?php

declare(strict_types=1);

namespace App\Aggregator;

class Longest
{
    /**
     * @phpcs:ignore SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @param array<mixed> $data
     */
    public function process(array $data, callable $callback): mixed
    {
        $longest = current($data);

        foreach ($data as $datum) {
            if (strlen($callback($datum)) > strlen($callback($longest))) {
                $longest = $datum;
            }
        }

        return $longest;
    }
}
