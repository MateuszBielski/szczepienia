<?php

namespace App\Controller;

use App\Entity\Choroba;
use App\Form\ChorobaType;
use App\Repository\ChorobaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/choroba")
 */
class ChorobaController extends AbstractController
{
    /**
     * @Route("/", name="choroba_index", methods={"GET"})
     */
    public function index(ChorobaRepository $chorobaRepository): Response
    {
        return $this->render('choroba/index.html.twig', [
            'chorobas' => $chorobaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="choroba_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $choroba = new Choroba();
        $form = $this->createForm(ChorobaType::class, $choroba);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($choroba);
            $entityManager->flush();

            return $this->redirectToRoute('choroba_index');
        }

        return $this->render('choroba/new.html.twig', [
            'choroba' => $choroba,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="choroba_show", methods={"GET","POST"})
     */
    public function show(Request $request, Choroba $choroba): Response
    {
        //$path = $request->getUri(); //miało odczytać stronę skąd przyszliśmy ,ale daje bieżącą
        
        return $this->render('choroba/show.html.twig', [
            'choroba' => $choroba,
            'sciezka' => $request->headers->get('referer'),
            'request'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="choroba_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Choroba $choroba): Response
    {
        $form = $this->createForm(ChorobaType::class, $choroba);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('choroba_index', [
                'id' => $choroba->getId(),
            ]);
        }

        return $this->render('choroba/edit.html.twig', [
            'choroba' => $choroba,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="choroba_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Choroba $choroba): Response
    {
        if ($this->isCsrfTokenValid('delete'.$choroba->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($choroba);
            $entityManager->flush();
        }

        return $this->redirectToRoute('choroba_index');
    }
}
