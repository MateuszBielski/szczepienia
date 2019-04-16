<?php

namespace App\Controller;

use App\Entity\Dawka;
use App\Form\DawkaType;
use App\Repository\DawkaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dawka")
 */
class DawkaController extends AbstractController
{
    /**
     * @Route("/", name="dawka_index", methods={"GET"})
     */
    public function index(DawkaRepository $dawkaRepository): Response
    {
        //$dawki = $dawkaRepository->findAll();
        //foreach($dawki as $dawka)$dawka->PrzeniesOdstepDoInterwalu();
        return $this->render('dawka/index.html.twig', [
            'dawkas' => $dawkaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dawka_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dawka = new Dawka();
        $form = $this->createForm(DawkaType::class, $dawka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dawka);
            $entityManager->flush();

            return $this->redirectToRoute('dawka_index');
        }

        return $this->render('dawka/new.html.twig', [
            'dawka' => $dawka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dawka_show", methods={"GET"})
     */
    public function show(Dawka $dawka): Response
    {
        return $this->render('dawka/show.html.twig', [
            'dawka' => $dawka,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dawka_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dawka $dawka): Response
    {
        $form = $this->createForm(DawkaType::class, $dawka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dawka_index', [
                'id' => $dawka->getId(),
            ]);
        }

        return $this->render('dawka/edit.html.twig', [
            'dawka' => $dawka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dawka_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dawka $dawka): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dawka->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dawka);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dawka_index');
    }
}
