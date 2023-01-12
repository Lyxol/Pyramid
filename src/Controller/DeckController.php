<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\Pyramid;
use App\Repository\CardRepository;
use App\service\DeckManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    #[Route('/deck', name: 'app_deck')]
    public function index(CardRepository $cardRepository,DeckManagerService $deckManagerService): Response
    {
        $deck = new Deck();
        $deck->setCards($cardRepository->findAll());
        $deckManagerService->shuffleCards($deck);
        dd($deck->getCards());
        return $this->render('deck/index.html.twig', [
            'controller_name' => 'DeckController',
        ]);
    }
}
