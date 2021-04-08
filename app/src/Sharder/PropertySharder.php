<?php

declare(strict_types=1);

namespace App\Sharder;

class PropertySharder implements SharderInterface
{
    /**
     * @inheritDoc
     */
    public function process(array $items, callable $method): array
    {
        $shards = [];

        foreach ($items as $item) {
            $shards[$method($item)][] = $item;
        }

        return $shards;
    }
}
