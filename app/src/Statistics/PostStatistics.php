<?php

declare(strict_types=1);

namespace App\Statistics;

use App\Aggregator\AvgLength;
use App\Aggregator\AvgTotal;
use App\Aggregator\Longest;
use App\Aggregator\Total;
use App\DataProvider\PostProvider;
use App\DTO\Post;
use App\Sharder\Date\MonthSharder;
use App\Sharder\Date\WeekOfYearSharder;
use App\Sharder\PropertySharder;
use App\Sharder\SharderInterface;
use InvalidArgumentException;

use function assert;

class PostStatistics
{
    private PostProvider $apiDataProvider;
    /**
     * @var array<array<Post|array>>
     */
    private array $shards = [];

    /**
     * @var array<array<string|callable>>
     */
    private array $sharders;

    public function __construct(PostProvider $apiDataProvider)
    {
        $this->apiDataProvider = $apiDataProvider;

        $this->sharders = [
            'week' => [
                'class' => WeekOfYearSharder::class,
                'value' => fn (Post $item) => $item->getCreatedTime(),
            ],
            'month' => [
                'class' => MonthSharder::class,
                'value' => fn (Post $item) => $item->getCreatedTime(),
            ],
            'user' => [
                'class' => PropertySharder::class,
                'value' => fn (Post $item) => $item->getFromId(),
            ],
        ];
    }

    /**
     * @return array<int, float>
     */
    public function getAvgLength(string $unit): array
    {
        $aggregator = new AvgLength();
        $result = [];

        foreach ($this->getShard($unit) as $shard => $posts) {
            $result[$shard] = $aggregator->process($posts, fn(Post $post) => $post->getMessage());
        }

        return $result;
    }

    /**
     * @return array<int, string>
     */
    public function getLongest(string $unit): array
    {
        $aggregator = new Longest();
        $result = [];

        foreach ($this->getShard($unit) as $shard => $posts) {
            $longest = $aggregator->process($posts, fn(Post $post) => $post->getMessage());

            if ($longest !== null) {
                $result[$shard] = $longest->getId();
            }
        }

        return $result;
    }

    /**
     * @return array<int, int>
     */
    public function getTotal(string $unit): array
    {
        $aggregator = new Total();
        $result = [];

        foreach ($this->getShard($unit) as $shard => $posts) {
            $result[$shard] = $aggregator->process($posts);
        }

        return $result;
    }

    /**
     * @return array<string, float>
     */
    public function getAvgPostsPerUser(string $unit): array
    {
        $aggregator = new AvgTotal();
        $result = [];

        foreach ($this->getShard($unit) as $shard => $posts) {
            $result[$shard] = $aggregator->process($posts);
        }

        return $result;
    }

    /**
     * @param array<array<Post|array>|Post> $data
     * @param array<string> $units
     * @return array<array<Post|array>>
     */
    private function createShard(array $data, array $units): array
    {
        $first = array_shift($units);
        $sharderParams = $this->sharders[$first] ?? null;

        if ($sharderParams === null) {
            throw new InvalidArgumentException(sprintf('Unknown shard type "%s"', $first));
        }

        if (!class_exists($sharderParams['class'])) {
            throw new InvalidArgumentException(sprintf('Undefined class "%s"', $sharderParams['class']));
        }

        $sharder = new $sharderParams['class']();
        assert($sharder instanceof SharderInterface);
        $data = $sharder->process($data, $sharderParams['value']);

        if (!empty($units)) {
            foreach ($data as $shard => $posts) {
                $data[$shard] = $this->createShard($posts, $units);
            }
        }

        return $data;
    }

    /**
     * @return array<array<Post|array>>
     */
    private function getShard(string $unit): array
    {
        if (!isset($this->shards[$unit])) {
            $units = explode('.', $unit);
            $data = $this->apiDataProvider->getData();

            $this->shards[$unit] = $this->createShard($data, $units);
        }

        return $this->shards[$unit];
    }
}
