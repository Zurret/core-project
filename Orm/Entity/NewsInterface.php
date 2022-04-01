<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

interface NewsInterface
{
    public function getId(): int;

    public function getTitle(): string;

    public function setTitle(string $title): NewsInterface;

    public function getText(): string;

    public function setText(string $text): NewsInterface;

    public function setCreatedAt(int $created_at): NewsInterface;

    public function getUpdatedAt(): int;

    public function setUpdatedAt(int $updated_at): NewsInterface;

    public function getAuthor(): ?PlayerInterface;

    public function setAuthor(PlayerInterface $author): NewsInterface;
}