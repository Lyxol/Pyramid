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
    public function index(PyramidRepository $pyramidRepository): Response
    { 
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        return $this->render('pyramid/index.html.twig', [
            'username' => $user->getEmail(),
            'pyramud' => "TODO"
        ]);
    }
    #[Route('/new', name: 'app_pyramid_new')]
    public function new(Request $request,PyramidRepository $pyramidRepository): Response
    {
        $pyramid = new Pyramid();
        $form = $this->createForm(PyramidType::class, $pyramid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pyramid = $form->getData();
            $pyramid->setAuthor($this->getUser()->getEmail());
            $pyramidRepository->save($pyramid,true);
            return $this->redirectToRoute('app_pyramid');
        }
        return $this->render('pyramid/new.html.twig',[
            'form' => $form->createView(),
            'pyramid' => $pyramid
        ]);
    }

    #[Route('/edit',name: 'app_pyramid_edit')]
    public function edit(Request $request,PyramidRepository $pyramidRepository)
    {
        $pyramid = new Pyramid();
        $form = $this->createForm(PyramidType::class, $pyramid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pyramid = $form->getData();
            $pyramid->setAuthor($this->getUser()->getEmail());
            $pyramidRepository->save($pyramid,true);
            return $this->redirectToRoute('/');
        }
        return $this->render('pyramid/edit.html.twig',[
            'form' => $form->createView(),
            'pyramid' => $pyramid
        ]);
    }

    #[Route('/delete',name: 'app_pyramid_delete',methods:['POST'])]
    public function delete(Request $request, PyramidRepository $pyramidRepository, Pyramid $pyramid) 
    {
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete-item',$submittedToken)){
            $pyramidRepository->remove($pyramid,true);
        }
    }
}
