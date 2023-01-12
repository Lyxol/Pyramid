<?php

namespace App\service;


use App\Entity\Deck;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeckManagerService
{


    public function __construct(private DeckRepository $deckRepository)
    {
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
        //$this->deckRepository->save($deck, true);
    }
}