<?php

declare(strict_types=1);

namespace App\Client;

use App\DTO\Post;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;

class SupermetrixApiClient implements ApiClientInterface
{
    private const BASE_URI = 'https://api.supermetrics.com';
    private const CONFIG = [
        'client_id' => 'ju16a6m81mhid5ue1z3v2g0uh',
        'email' => 'ales.eremeev@gmail.com',
        'name' => 'Ales Eremeev',
    ];

    private ?string $apiToken = null;
    private Client $client;

    /**
     * @var array<Post>
     */
    private array $posts = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * @inheritDoc
     */
    public function getPosts(): array
    {
        if (empty($this->posts)) {
            $this->loadData();
        }

        return $this->posts;
    }

    private function loadData(int $pages = 10): void
    {
        $client = $this->client;
        $token = $this->getToken();

        $requests = static function (int $total) use ($client, $token) {
            $uri = '/assignment/posts';

            for ($i = 1; $i <= $total; $i++) {
                yield static fn () => $client->getAsync($uri, ['query' => ['sl_token' => $token, 'page' => $i]]);
            }
        };

        $pool = new Pool(
            $client,
            $requests($pages),
            [
                'concurrency' => 5,
                /**
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                'fulfilled' => function (Response $response, $index): void {
                    $data = json_decode($response->getBody()->getContents(), true);

                    foreach ($data['data']['posts'] as $post) {
                        $this->posts[] = $this->transformToDto($post);
                    }
                },
            ],
        );

        $promise = $pool->promise();
        $promise->wait();
    }

    private function getToken(): string
    {
        if ($this->apiToken === null) {
            $res = $this->client->post(
                '/assignment/register',
                [
                    'form_params' => self::CONFIG,
                ],
            );

            $date = json_decode($res->getBody()->getContents(), true);

            $this->apiToken = $date['data']['sl_token'];
        }

        return $this->apiToken;
    }

    /**
     * @param array<string> $postData
     */
    private function transformToDto(array $postData): Post
    {
        $time = new DateTime($postData['created_time']);

        $post = new Post();
        $post->setId($postData['id']);
        $post->setFromId($postData['from_id']);
        $post->setFromName($postData['from_name']);
        $post->setMessage($postData['message']);
        $post->setType($postData['type']);
        $post->setCreatedTime($time);

        return $post;
    }
}
