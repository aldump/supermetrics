<?php

declare(strict_types=1);

namespace App\DTO;

use DateTimeInterface;

class Post
{
    private string $id;
    private string $fromName;
    private string $fromId;
    private string $message;
    private string $type;
    private DateTimeInterface $createdTime;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): void
    {
        $this->fromName = $fromName;
    }

    public function getFromId(): string
    {
        return $this->fromId;
    }

    public function setFromId(string $fromId): void
    {
        $this->fromId = $fromId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCreatedTime(): DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(DateTimeInterface $createdTime): void
    {
        $this->createdTime = $createdTime;
    }
}
