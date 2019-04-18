<?php

namespace App\Controller;

use App\Entity\Warunek;
use App\Form\WarunekType;
use App\Repository\WarunekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/warunek")
 */
class WarunekController extends AbstractController
{
    /**
     * @Route("/", name="warunek_index", methods={"GET"})
     */
    public function index(WarunekRepository $warunekRepository): Response
    {
        return $this->render('warunek/index.html.twig', [
            'waruneks' => $warunekRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="warunek_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $warunek = new Warunek();
        $form = $this->createForm(WarunekType::class, $warunek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($warunek);
            $entityManager->flush();

            return $this->redirectToRoute('warunek_index');
        }

        return $this->render('warunek/new.html.twig', [
            'warunek' => $warunek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warunek_show", methods={"GET"})
     */
    public function show(Warunek $warunek): Response
    {
        return $this->render('warunek/show.html.twig', [
            'warunek' => $warunek,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="warunek_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Warunek $warunek): Response
    {
        $form = $this->createForm(WarunekType::class, $warunek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warunek_index', [
                'id' => $warunek->getId(),
            ]);
        }

        return $this->render('warunek/edit.html.twig', [
            'warunek' => $warunek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warunek_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Warunek $warunek): Response
    {
        if ($this->isCsrfTokenValid('delete'.$warunek->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($warunek);
            $entityManager->flush();
        }

        return $this->redirectToRoute('warunek_index');
    }
}
