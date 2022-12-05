<?php

namespace App\Entity;

use App\Repository\PyramidRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PyramidRepository::class)]
class Pyramid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardPlayed = null;

    #[ORM\Column(length: 255)]
    private ?string $player = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardPlayed(): ?string
    {
        return $this->cardPlayed;
    }

    public function setCardPlayed(?string $cardPlayed): self
    {
        $this->cardPlayed = $cardPlayed;

        return $this;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
