<?php

namespace App\Controller;

use App\Entity\KalendarzSzczepien;
use App\Form\KalendarzSzczepienType;
use App\Repository\KalendarzSzczepienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kalendarz/szczepien")
 */
class KalendarzSzczepienController extends AbstractController
{
    /**
     * @Route("/", name="kalendarz_szczepien_index", methods={"GET"})
     */
    public function index(KalendarzSzczepienRepository $kalendarzSzczepienRepository): Response
    {
        return $this->render('kalendarz_szczepien/index.html.twig', [
            'kalendarz_szczepiens' => $kalendarzSzczepienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="kalendarz_szczepien_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $kalendarzSzczepien = new KalendarzSzczepien();
        $form = $this->createForm(KalendarzSzczepienType::class, $kalendarzSzczepien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kalendarzSzczepien);
            $entityManager->flush();

            return $this->redirectToRoute('kalendarz_szczepien_index');
        }

        return $this->render('kalendarz_szczepien/new.html.twig', [
            'kalendarz_szczepien' => $kalendarzSzczepien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kalendarz_szczepien_show", methods={"GET"})
     */
    public function show(KalendarzSzczepien $kalendarzSzczepien): Response
    {
        return $this->render('kalendarz_szczepien/show.html.twig', [
            'kalendarz_szczepien' => $kalendarzSzczepien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="kalendarz_szczepien_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KalendarzSzczepien $kalendarzSzczepien): Response
    {
        $form = $this->createForm(KalendarzSzczepienType::class, $kalendarzSzczepien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kalendarz_szczepien_index', [
                'id' => $kalendarzSzczepien->getId(),
            ]);
        }

        return $this->render('kalendarz_szczepien/edit.html.twig', [
            'kalendarz_szczepien' => $kalendarzSzczepien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kalendarz_szczepien_delete", methods={"DELETE"})
     */
    public function delete(Request $request, KalendarzSzczepien $kalendarzSzczepien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kalendarzSzczepien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kalendarzSzczepien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kalendarz_szczepien_index');
    }
}
