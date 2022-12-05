<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends AbstractController
{
    #[Route('/player', name: 'app_player')]
    public function index(): Response
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    #[Route('/player/form')]
    public function _form(Request $request): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        if($form->isSubmitted() && $form->isValid()){
            $player = $form->getData();
            return $this->redirectToRoute('/player');
        }
        return $this->render('player/_Form.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/player/new')]
    public function new(): Response
    {
        return $this->render('player/new.html.twig',[
            'controller_name' => 'PlayerController',
        ]);
    }

    #[Route('/player/edit')]
    public function edit(): Response
    {
        return $this->render('player/edit.html.twig',[
            'controller_name' => 'PlayerController',
        ]);
    }

    #[Route('/player/delete')]
    public function delete(): Response
    {
        return $this->render('player/delete.html.twig',[
            'controller_name' => 'PlayerController',
        ]);
    }
}
