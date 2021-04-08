<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Client\ApiClientInterface;
use App\DTO\Post;

class PostProvider implements DataProviderInterface
{
    private ApiClientInterface $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return array<Post>
     */
    public function getData(): array
    {
        return $this->apiClient->getPosts();
    }
}
