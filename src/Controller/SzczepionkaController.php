<?php

namespace App\Controller;

use App\Entity\Szczepionka;
use App\Form\SzczepionkaType;
use App\Form\SzczepionkaCtType;
use App\Repository\SzczepionkaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/szczepionka")
 */
class SzczepionkaController extends AbstractController
{
    /**
     * @Route("/", name="szczepionka_index", methods={"GET"})
     */
    public function index(SzczepionkaRepository $szczepionkaRepository): Response
    {
        return $this->render('szczepionka/index.html.twig', [
            'szczepionkas' => $szczepionkaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="szczepionka_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $szczepionka = new Szczepionka();
        $form = $this->createForm(SzczepionkaCtType::class, $szczepionka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($szczepionka);
            $entityManager->flush();

            return $this->redirectToRoute('szczepionka_index');
        }

        return $this->render('szczepionka/new.html.twig', [
            'szczepionka' => $szczepionka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepionka_show", methods={"GET"})
     */
    public function show(Szczepionka $szczepionka): Response
    {
        return $this->render('szczepionka/show.html.twig', [
            'szczepionka' => $szczepionka,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="szczepionka_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Szczepionka $szczepionka): Response
    {
        $form = $this->createForm(SzczepionkaCtType::class, $szczepionka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('szczepionka_index', [
                'id' => $szczepionka->getId(),
            ]);
        }

        return $this->render('szczepionka/edit.html.twig', [
            'szczepionka' => $szczepionka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepionka_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Szczepionka $szczepionka): Response
    {
        if ($this->isCsrfTokenValid('delete'.$szczepionka->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($szczepionka);
            $entityManager->flush();
        }

        return $this->redirectToRoute('szczepionka_index');
    }
    
    
    /**
     * @Route("/{id}/dodajSchemat", name="dodaj_schemat", methods={"GET","POST"})
     */
    public function dodajSchemat(Request $request, Szczepionka $szczepionka): Response
    {
        return $this->redirectToRoute('schemat_new',['id'=> $szczepionka->getId()]);
    }
}
