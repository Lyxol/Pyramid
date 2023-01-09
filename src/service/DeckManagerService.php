<?php

namespace App\service;


use App\Entity\Deck;

use App\Repository\DeckRepository;


class DeckManagerService
{
    public function retrieveCard(DeckRepository $deckRepository){
        $deckRepository->findAll();
    }
    public function shuffleCards(Deck $deck) {
        var_dump($deck);
        shuffle($deck);
        var_dump($deck);
    }
}