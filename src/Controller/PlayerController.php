<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/player')]
class PlayerController extends AbstractController
{
    #[Route('/', name: 'app_player')]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    #[Route('/new', name: 'app_player_new', methods:['GET'])]
    public function new(Request $request,PlayerRepository $playerRepository): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $player = $form->getData();
            $playerRepository->save($player,true);
            return $this->redirectToRoute('/player');
        }
        return $this->render('player/new.html.twig',[
            'form' => $form->createView(),
            'player' => $player
        ]);
    }

    #[Route('/edit',name: 'app_player_edit', methods:['GET'])]
    public function edit(Request $request,PlayerRepository $playerRepository)
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $player = $form->getData();
            $playerRepository->save($player,true);
            return $this->redirectToRoute('/player');
        }
        return $this->render('player/new.html.twig',[
            'form' => $form->createView(),
            'player' => $player
        ]);
    }

    #[Route('/delete',name: 'app_player_delete',methods:['POST'])]
    public function delete(Request $request, PlayerRepository $playerRepository, Player $player) 
    {
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete-item',$submittedToken)){
            $playerRepository->remove($player,true);
        }
    }
}
