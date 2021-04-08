<?php

declare(strict_types=1);

namespace App\Client;

use App\DTO\Post;

interface ApiClientInterface
{
    /**
     * @return array<Post>
     */
    public function getPosts(): array;
}
