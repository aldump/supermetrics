<?php

declare(strict_types=1);

namespace App\Sharder\Date;

class MonthSharder extends DateSharder
{
    protected function getShardUnit(): string
    {
        return 'month';
    }
}
