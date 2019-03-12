<?php

namespace App\Controller;

use App\Entity\Telefon;
use App\Form\TelefonType;
use App\Repository\TelefonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/telefon")
 */
class TelefonController extends AbstractController
{
    /**
     * @Route("/", name="telefon_index", methods={"GET"})
     */
    public function index(TelefonRepository $telefonRepository): Response
    {
        return $this->render('telefon/index.html.twig', [
            'telefons' => $telefonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="telefon_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $telefon = new Telefon();
        $form = $this->createForm(TelefonType::class, $telefon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($telefon);
            $entityManager->flush();

            return $this->redirectToRoute('telefon_index');
        }

        return $this->render('telefon/new.html.twig', [
            'telefon' => $telefon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="telefon_show", methods={"GET"})
     */
    public function show(Telefon $telefon): Response
    {
        return $this->render('telefon/show.html.twig', [
            'telefon' => $telefon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="telefon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Telefon $telefon): Response
    {
        $form = $this->createForm(TelefonType::class, $telefon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('telefon_index', [
                'id' => $telefon->getId(),
            ]);
        }

        return $this->render('telefon/edit.html.twig', [
            'telefon' => $telefon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="telefon_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Telefon $telefon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telefon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($telefon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('telefon_index');
    }
}
