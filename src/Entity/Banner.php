<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $file = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_uploaded = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_publish = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_unpublish = null;

    #[ORM\Column]
    private ?int $show_duration = 10;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getDateUploaded(): ?\DateTimeInterface
    {
        return $this->date_uploaded;
    }

    public function setDateUploaded(\DateTimeInterface $date_uploaded): static
    {
        $this->date_uploaded = $date_uploaded;

        return $this;
    }

    public function getDatePublish(): ?\DateTimeInterface
    {
        return $this->date_publish;
    }

    public function setDatePublish(?\DateTimeInterface $date_publish): static
    {
        $this->date_publish = $date_publish;

        return $this;
    }

    public function getDateUnpublish(): ?\DateTimeInterface
    {
        return $this->date_unpublish;
    }

    public function setDateUnpublish(?\DateTimeInterface $date_unpublish): static
    {
        $this->date_unpublish = $date_unpublish;

        return $this;
    }

    public function getShowDuration(): ?int
    {
        return $this->show_duration;
    }

    public function setShowDuration(int $show_duration): static
    {
        $this->show_duration = $show_duration;

        return $this;
    }
}
