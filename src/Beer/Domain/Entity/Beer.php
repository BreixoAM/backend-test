<?php

declare(strict_types=1);

namespace App\Beer\Domain\Entity;

class Beer
{
    private int $id;

    private ?string $name;

    private ?string $description;

    private ?string $imageUrl;

    private ?string $tagLine;

    private ?string $firstBrewed;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getTagLine(): ?string
    {
        return $this->tagLine;
    }

    public function setTagLine(?string $tagLine): self
    {
        $this->tagLine = $tagLine;

        return $this;
    }

    public function getFirstBrewed(): ?string
    {
        return $this->firstBrewed;
    }

    public function setFirstBrewed(?string $firstBrewed): self
    {
        $this->firstBrewed = $firstBrewed;

        return $this;
    }
}
