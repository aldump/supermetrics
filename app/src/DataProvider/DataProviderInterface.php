<?php

declare(strict_types=1);

namespace App\DataProvider;

interface DataProviderInterface
{
    /**
     * @phpcs:ignore SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @return array<mixed>
     */
    public function getData(): array;
}
