<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/card')]
class CardController extends AbstractController
{
    #[Route('/{id}', name: 'app_card_index', methods: ['GET'])]
    public function index(CardRepository $cardRepository,$id): Response
    {
        return $this->render('card/index.html.twig', [
            'card' => $cardRepository->findOneById($id+1),
        ]);
    }
}
