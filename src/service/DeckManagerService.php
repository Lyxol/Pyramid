<?php

namespace App\service;


use App\Entity\Deck;
use App\Entity\Pyramid;
use App\Repository\DeckRepository;
use App\Repository\CardRepository;

class DeckManagerService
{


    public function __construct(private DeckRepository $deckRepository, private CardRepository $cardRepository)
    {
    }

    public function newDeck(Pyramid $pyramid)
    {
        $deck = new Deck();
        $deck->setCards($this->cardRepository->findAll());
        $deck->setPyramid($pyramid);
        $this->shuffleCards($deck);
        return $deck;
    }

    public function shuffleCards(Deck $deck)
    {
        $cards = $deck->getCards();
        $tempCards = [];
        while (!$cards->isEmpty()) {
            $positionCard = array_rand($cards->toArray());
            $randomCard = $cards->get($positionCard);
            $tempCards[] = $randomCard;
            $cards->remove($positionCard);
        }
        $deck->setCards($tempCards);
        return $deck;
    }

    public function saveDeck(Deck $deck)
    {
        $this->deckRepository->save($deck);
    }
}
