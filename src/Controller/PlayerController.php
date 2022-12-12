<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/player')]
class PlayerController extends AbstractController
{
    #[Route('/', name: 'app_player')]
    public function index(): Response
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    #[Route('/login', name: 'app_player_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new Player();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('player/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $error,
        ]);
    }
}
