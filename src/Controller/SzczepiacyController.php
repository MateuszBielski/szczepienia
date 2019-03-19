<?php

namespace App\Controller;

use App\Entity\Szczepiacy;
use App\Form\SzczepiacyType;
use App\Repository\SzczepiacyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/szczepiacy")
 */
class SzczepiacyController extends AbstractController
{
    /**
     * @Route("/", name="szczepiacy_index", methods={"GET"})
     */
    public function index(SzczepiacyRepository $szczepiacyRepository): Response
    {
        return $this->render('szczepiacy/index.html.twig', [
            'szczepiacies' => $szczepiacyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="szczepiacy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $szczepiacy = new Szczepiacy();
        $form = $this->createForm(SzczepiacyType::class, $szczepiacy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($szczepiacy);
            $entityManager->flush();

            return $this->redirectToRoute('szczepiacy_index');
        }

        return $this->render('szczepiacy/new.html.twig', [
            'szczepiacy' => $szczepiacy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepiacy_show", methods={"GET"})
     */
    public function show(Szczepiacy $szczepiacy): Response
    {
        return $this->render('szczepiacy/show.html.twig', [
            'szczepiacy' => $szczepiacy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="szczepiacy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Szczepiacy $szczepiacy): Response
    {
        $form = $this->createForm(SzczepiacyType::class, $szczepiacy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('szczepiacy_index', [
                'id' => $szczepiacy->getId(),
            ]);
        }

        return $this->render('szczepiacy/edit.html.twig', [
            'szczepiacy' => $szczepiacy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepiacy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Szczepiacy $szczepiacy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$szczepiacy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($szczepiacy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('szczepiacy_index');
    }
}
