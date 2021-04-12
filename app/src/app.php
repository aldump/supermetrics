<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Client\SupermetrixApiClient;
use App\DataProvider\PostProvider;
use App\Statistics\PostStatistics;

$dataProvider = new PostProvider(new SupermetrixApiClient());

$postStatistics = new PostStatistics($dataProvider);

echo json_encode(
    [
        'a' => $postStatistics->getAvgLength('month'),
        'b' => $postStatistics->getLongest('month'),
        'c' => $postStatistics->getTotal('week'),
        'd' => $postStatistics->getAvgPostsPerUser('user.month'),
    ], JSON_PRETTY_PRINT
) . PHP_EOL;
