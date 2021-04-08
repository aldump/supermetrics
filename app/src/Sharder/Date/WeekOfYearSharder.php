<?php

declare(strict_types=1);

namespace App\Sharder\Date;

class WeekOfYearSharder extends DateSharder
{
    protected function getShardUnit(): string
    {
        return 'weekOfYear';
    }
}
