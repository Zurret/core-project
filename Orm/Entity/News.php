<?php

declare(strict_types=1);

namespace Core\Orm\Entity;

/**
 * @Entity(repositoryClass="Core\Orm\Repository\NewsRepository")
 *
 * @Table(
 *     name="core_news",
 *     indexes={
 *     }
 * )
 */
class News implements NewsInterface
{
    /**
     * @Id
     *
     * @Column(type="integer")
     *
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @Column(type="string", length=255) */
    private string $title = '';

    /** @Column(type="text") */
    private string $text = '';

    /** @Column(type="integer", nullable=true, options={"default" : null}) */
    private ?int $author_id = 0;

    /** @Column(type="integer", nullable=false, options={"default" : 0}) */
    private int $created_at = 0;

    /** @Column(type="integer", nullable=false, options={"default" : 0}) */
    private int $updated_at = 0;

    /**
     * @ManyToOne(targetEntity="Player")
     *
     * @JoinColumn(name="author_id", referencedColumnName="id")
     */
    private ?PlayerInterface $author;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): NewsInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getShortText(int $length = 200): string
    {
        return strlen($this->text) > $length ? substr($this->text, 0, $length).'...' : $this->text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): NewsInterface
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $created_at): NewsInterface
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): int
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(int $updated_at): NewsInterface
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAuthor(): ?PlayerInterface
    {
        return $this->author;
    }

    public function setAuthor(PlayerInterface $author): NewsInterface
    {
        $this->author = $author;

        return $this;
    }
}
