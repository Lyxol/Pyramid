<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/card')]
class CardController extends AbstractController
{
    #[Route('/', name: 'app_card_index', methods: ['GET'])]
    public function index(CardRepository $cardRepository): Response
    {
        return $this->render('card/index.html.twig', [
            'cards' => $cardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CardRepository $cardRepository): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cardRepository->save($card, true);

            return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('card/new.html.twig', [
            'card' => $card,
            'form' => $form,
        ]);
    }

    #[Route('/generate', name: 'app_card_generate', methods: ['GET'])]
    public function generate(CardRepository $cardRepository): Response
    {

        $id = 0;

        for ($i = 1; $i <= 4; $i++) {
            for ($j = 1; $j <= 13; $j++) {
                $card = new Card();
                if ($i === 1) {
                    var_dump('test = 1');
                    $card->setColor("Piques");
                    $card->setValue($j);
                    $card->setPosition([]);
                    if ($j < 10) {
                        $card->setImg("P_0". $j. ".jpg");
                    } else {
                        $card->setImg("P_" .$j . ".jpg");
                    }
                }
                if ($i === 2) {
                    var_dump('test = 2');
                    $card->setColor("Coeur");
                    $card->setValue($j);
                    $card->setPosition([]);
                    if ($j < 10) {
                        $card->setImg("C_0". $j. ".jpg");
                    } else {
                        $card->setImg("C_". $j .".jpg");
                    }
                }
                if ($i === 3) {

                    var_dump('test = 3');
                    $card->setColor("Carreau");
                    $card->setValue($j);
                    $card->setPosition([]);
                    if ($j < 10) {
                        $card->setImg("K_0". $j .".jpg");
                    } else {
                        $card->setImg("K_". $j . ".jpg");
                    }
                }
                if ($i === 4) {
                    var_dump('test = 4');
                    $card->setColor("Trefle");
                    $card->setValue($j);
                    $card->setPosition([]);
                    if ($j < 10) {
                        $card->setImg("T_0" . $j . ".jpg");
                    } else {
                        $card->setImg("T_" . $j . ".jpg");
                    }
                }
                $id++;
                $cardRepository->save($card);
            }

        }
        $cardRepository->save($card, true);
        new JsonResponse(json_encode('true'));
    }


    #[Route('/{id}/edit', name: 'app_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Card $card, CardRepository $cardRepository): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cardRepository->save($card, true);

            return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('card/edit.html.twig', [
            'card' => $card,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_card_delete', methods: ['POST'])]
    public function delete(Request $request, Card $card, CardRepository $cardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$card->getId(), $request->request->get('_token'))) {
            $cardRepository->remove($card, true);
        }

        return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
    }
}
