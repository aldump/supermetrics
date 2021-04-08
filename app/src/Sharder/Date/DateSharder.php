<?php

declare(strict_types=1);

namespace App\Sharder\Date;

use App\Sharder\SharderInterface;
use Carbon\Carbon;

abstract class DateSharder implements SharderInterface
{
    abstract protected function getShardUnit(): string;

    /**
     * @inheritDoc
     */
    public function process(array $items, callable $method): array
    {
        $unit = $this->getShardUnit();

        $shards = [];

        foreach ($items as $item) {
            $date = new Carbon($method($item));
            $shards[$date->get($unit)][] = $item;
        }

        return $shards;
    }
}
