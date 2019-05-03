<?php

namespace App\Controller;

use App\Entity\Pacjent;
use App\Form\PacjentType;
use App\Repository\PacjentRepository;
use App\Repository\SzczepienieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pacjent")
 */
class PacjentController extends AbstractController
{
    /**
     * @Route("/", name="pacjent_index", methods={"GET"})
     */
    public function index(PacjentRepository $pacjentRepository): Response
    {
        return $this->render('pacjent/index.html.twig', [
            'pacjents' => $pacjentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pacjent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pacjent = new Pacjent();
        $form = $this->createForm(PacjentType::class, $pacjent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pacjent);
            $entityManager->flush();

            return $this->redirectToRoute('pacjent_index');
        }

        return $this->render('pacjent/new.html.twig', [
            'pacjent' => $pacjent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pacjent_show", methods={"GET"})
     */
    public function show(Pacjent $pacjent,SzczepienieRepository $szczepienieRepository): Response
    {
        $pacjent->PogrupujSzczepienia();
        return $this->render('pacjent/show.html.twig', [
            'pacjent' => $pacjent,
            //'szczepienia' => $szczepienieRepository->findByPacjentId($pacjent->getId()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pacjent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pacjent $pacjent): Response
    {
        $form = $this->createForm(PacjentType::class, $pacjent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pacjent_index', [
                'id' => $pacjent->getId(),
            ]);
        }

        return $this->render('pacjent/edit.html.twig', [
            'pacjent' => $pacjent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pacjent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pacjent $pacjent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pacjent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pacjent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pacjent_index');
    }
}
