<?php

namespace App\Controller;

use App\Entity\Uzytkownik;
use App\Form\UzytkownikEtType;
use App\Form\UzytkownikType;
use App\Repository\UzytkownikRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/uzytkownik")
 */
class UzytkownikController extends AbstractController
{
    /**
     * @Route("/", name="uzytkownik_index", methods={"GET"})
     */
    public function index(UzytkownikRepository $uzytkownikRepository): Response
    {
        return $this->render('uzytkownik/index.html.twig', [
            'uzytkowniks' => $uzytkownikRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="uzytkownik_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uzytkownik = new Uzytkownik();
        $form = $this->createForm(UzytkownikEtType::class, $uzytkownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uzytkownik);
            $entityManager->flush();

            return $this->redirectToRoute('uzytkownik_index');
        }

        return $this->render('uzytkownik/new.html.twig', [
            'uzytkownik' => $uzytkownik,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uzytkownik_show", methods={"GET"})
     */
    public function show(Uzytkownik $uzytkownik): Response
    {
        return $this->render('uzytkownik/show.html.twig', [
            'uzytkownik' => $uzytkownik,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="uzytkownik_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Uzytkownik $uzytkownik): Response
    {
        $form = $this->createForm(UzytkownikEtType::class, $uzytkownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uzytkownik_index', [
                'id' => $uzytkownik->getId(),
            ]);
        }

        return $this->render('uzytkownik/edit.html.twig', [
            'uzytkownik' => $uzytkownik,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uzytkownik_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Uzytkownik $uzytkownik): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uzytkownik->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uzytkownik);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uzytkownik_index');
    }
}
