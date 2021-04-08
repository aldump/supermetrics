<?php

declare(strict_types=1);

namespace App\Sharder;

interface SharderInterface
{
    /**
     * @phpcs:disable SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @param array<mixed> $items
     * @return array<mixed>
     */
    public function process(array $items, callable $method): array;
}
