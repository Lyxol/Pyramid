<?php

namespace App\Controller;

use App\Entity\Pyramid;
use App\Form\PyramidType;
use App\Repository\PyramidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pyramid')]
class PyramidController extends AbstractController
{
    #[Route('/', name: 'app_pyramid')]
    public function index(PyramidRepository $pyramidRepository, Request $request): Response
    {
        $id = $request->query->get('id');
        if (!is_null($id)) {
            $currentPyramid = $pyramidRepository->findById($id);
            $PyramidTab = [];
            if (!empty($currentPyramid)) {
                $currentPyramid = $currentPyramid[0];
                $PyramidRow = [];
                $count = 1;
                $fake_value = 0;
                for ($i = 0; $i < $currentPyramid->getBase(); $i++) {
                    for ($j = 0; $j < $count; $j++) {
                        $PyramidRow[] = $fake_value;
                        $fake_value++;
                    }
                    $PyramidTab[] = $PyramidRow;
                    $PyramidRow = [];
                    $count++;
                }
            }
        } else {
            $currentPyramid  = null;
            $PyramidTab = null;
        }
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $listPyramid = $pyramidRepository->findByAuthor($user->getEmail());
        return $this->render('pyramid/index.html.twig', [
            'username' => $user->getEmail(),
            'listPyramid' => $listPyramid,
            'currentPyramid' => $currentPyramid,
            'PyramidTab' => $PyramidTab
        ]);
    }
    #[Route('/new', name: 'app_pyramid_new')]
    public function new(Request $request, PyramidRepository $pyramidRepository): Response
    {
        $pyramid = new Pyramid();
        $form = $this->createForm(PyramidType::class, $pyramid);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pyramid = $form->getData();
            $pyramid->setAuthor($this->getUser()->getEmail());
            $pyramidRepository->save($pyramid, true);
            return $this->redirectToRoute('app_pyramid');
        }
        return $this->render('pyramid/new.html.twig', [
            'form' => $form->createView(),
            'pyramid' => $pyramid
        ]);
    }

    #[Route('/edit', name: 'app_pyramid_edit')]
    public function edit(Request $request, PyramidRepository $pyramidRepository): Response
    {
        $pyramid = new Pyramid();
        $form = $this->createForm(PyramidType::class, $pyramid);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pyramid = $form->getData();
            $pyramid->setAuthor($this->getUser()->getEmail());
            $pyramidRepository->save($pyramid, true);
            return $this->redirectToRoute('app_pyramid');
        }
        return $this->render('pyramid/edit.html.twig', [
            'form' => $form->createView(),
            'pyramid' => $pyramid
        ]);
    }

    #[Route('/delete', name: 'app_pyramid_delete', methods: ['POST'])]
    public function delete(Request $request, PyramidRepository $pyramidRepository, Pyramid $pyramid)
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $pyramidRepository->remove($pyramid, true);
        }
    }
}
