<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'deck', targetEntity: Card::class)]
    private Collection $cards;

    #[ORM\OneToOne(inversedBy: 'deck', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pyramid $pyramid = null;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function setCards(array $cards): self
    {
        $cards = new ArrayCollection($cards);
        $this->cards = $cards;
        return $this;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setDeck($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getDeck() === $this) {
                $card->setDeck(null);
            }
        }

        return $this;
    }

    public function getPyramid(): ?Pyramid
    {
        return $this->pyramid;
    }

    public function setPyramid(Pyramid $pyramid): self
    {
        $this->pyramid = $pyramid;

        return $this;
    }

}
