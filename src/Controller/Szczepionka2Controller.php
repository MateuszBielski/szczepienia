<?php

namespace App\Controller;

use App\Entity\Szczepionka2;
use App\Form\Szczepionka2Type;
use App\Repository\Szczepionka2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/szczepionka2")
 */
class Szczepionka2Controller extends AbstractController
{
    /**
     * @Route("/", name="szczepionka2_index", methods={"GET"})
     */
    public function index(Szczepionka2Repository $szczepionka2Repository): Response
    {
        return $this->render('szczepionka2/index.html.twig', [
            'szczepionka2s' => $szczepionka2Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="szczepionka2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $szczepionka2 = new Szczepionka2();
        $form = $this->createForm(Szczepionka2Type::class, $szczepionka2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($szczepionka2);
            $entityManager->flush();

            return $this->redirectToRoute('szczepionka2_index');
        }

        return $this->render('szczepionka2/new.html.twig', [
            'szczepionka2' => $szczepionka2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepionka2_show", methods={"GET"})
     */
    public function show(Szczepionka2 $szczepionka2): Response
    {
        www;
        return $this->render('szczepionka2/show.html.twig', [
            'szczepionka2' => $szczepionka2,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="szczepionka2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Szczepionka2 $szczepionka2): Response
    {
        $form = $this->createForm(Szczepionka2Type::class, $szczepionka2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('szczepionka2_index', [
                'id' => $szczepionka2->getId(),
            ]);
        }

        return $this->render('szczepionka2/edit.html.twig', [
            'szczepionka2' => $szczepionka2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepionka2_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Szczepionka2 $szczepionka2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$szczepionka2->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($szczepionka2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('szczepionka2_index');
    }
}
