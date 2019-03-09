<?php

namespace App\Controller;

use App\Entity\Grupa;
use App\Entity\Uzytkownik;
use App\Form\Grupa1Type;
use App\Repository\GrupaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grupa")
 */
class GrupaController extends AbstractController
{
    /**
     * @Route("/", name="grupa_index", methods={"GET"})
     */
    public function index(GrupaRepository $grupaRepository): Response
    {
        return $this->render('grupa/index.html.twig', [
            'grupas' => $grupaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="grupa_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grupa = new Grupa();
        $uzytk1 = new Uzytkownik();
        $uzytk1->setImie('imie1_GrContr');
        $grupa->addUser($uzytk1);
        $uzytk2 = new Uzytkownik();
        $uzytk2->setImie('imie2_GrContr');
        $grupa->addUser($uzytk2);
        $form = $this->createForm(Grupa1Type::class, $grupa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grupa);
            $entityManager->persist($uzytk1);
            $entityManager->persist($uzytk2);
            $entityManager->flush();

            return $this->redirectToRoute('grupa_index');
        }

        return $this->render('grupa/new.html.twig', [
            'grupa' => $grupa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grupa_show", methods={"GET"})
     */
    public function show(Grupa $grupa): Response
    {
        return $this->render('grupa/show.html.twig', [
            'grupa' => $grupa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="grupa_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grupa $grupa): Response
    {
        $form = $this->createForm(Grupa1Type::class, $grupa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grupa_index', [
                'id' => $grupa->getId(),
            ]);
        }

        return $this->render('grupa/edit.html.twig', [
            'grupa' => $grupa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grupa_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Grupa $grupa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grupa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grupa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grupa_index');
    }
}
