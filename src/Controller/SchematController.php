<?php

namespace App\Controller;

use App\Entity\Schemat;
use App\Entity\Dawka;
use App\Entity\Szczepionka;
use App\Entity\Pacjent;
use App\Entity\KalendarzSzczepien;
use App\Form\SchematType;
use App\Repository\SchematRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/schemat")
 */
class SchematController extends AbstractController
{
    /**
     * @Route("/", name="schemat_index", methods={"GET"})
     */
    public function index(SchematRepository $schematRepository): Response
    {
        return $this->render('schemat/index.html.twig', [
            //->findAll(),
            'schemats' => $schematRepository->findAllOrderByStartYearSzczepionkaNazwa(),
        ]);
    }

    /**
     * @Route("/new{id}", name="schemat_new", methods={"GET","POST"})
     */
    public function new(Request $request, Szczepionka $szczepionka): Response
    {
        $schemat = new Schemat();
        $yearNow = (new \DateTime('now'))->format('Y');
        $schemat->setStartYear(new \DateTime("$yearNow-01-01"));
        $schemat->setPodawania($szczepionka);
        //poniżej Dawka ma w konstruktorze inicjowane przykładowe wartości interwałów
        $form = $this->createForm(SchematType::class, $schemat, ['prototype_data_opt' => new Dawka(),]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schemat->DlaMoichDawekUstawMnieIponumeruj();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($schemat);
            $entityManager->flush();
            $this->UaktualnijKalendarze();
            return $this->redirectToRoute('schemat_show',['id'=> $schemat->getId()]);
        }

        return $this->render('schemat/new.html.twig', [
            'schemat' => $schemat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="schemat_show", methods={"GET"})
     */
    public function show(Schemat $schemat): Response
    {
        return $this->render('schemat/show.html.twig', [
            'schemat' => $schemat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="schemat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Schemat $schemat): Response
    {
        $form = $this->createForm(SchematType::class, $schemat, ['prototype_data_opt' => new Dawka(),]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schemat->DlaMoichDawekUstawMnieIponumeruj();
            $this->getDoctrine()->getManager()->flush();
            
            $this->UaktualnijKalendarze();
            return $this->redirectToRoute('schemat_index', [
                'id' => $schemat->getId(),
            ]);
        }

        return $this->render('schemat/edit.html.twig', [
            'schemat' => $schemat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="schemat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Schemat $schemat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$schemat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($schemat);
            $entityManager->flush();
            $this->UaktualnijKalendarze();
        }

        return $this->redirectToRoute('schemat_index');
    }
    public function UaktualnijKalendarze(){
        //zmiana schematu może wpłynąć na kalendarz każdego pacjenta
        $wszyscyPacjenci = $this->getDoctrine()->getRepository(Pacjent::class)->findAll();
        //$wszystkieSzczepionki = $this->getDoctrine()->getRepository(Szczepionka::class)->findAll();
        $wszystkieSchematy = $this->getDoctrine()->getRepository(Schemat::class)->findAll();
        $entityManager = $this->getDoctrine()->getManager();
        foreach($wszyscyPacjenci as $pacjent){
            $pacjent->UaktualnijKalendarz($wszystkieSchematy);
            $entityManager->persist($pacjent->getKalendarzSzczepien());
        }
        $entityManager->flush();
        //KalendarzSzczepien::DopasujSchematyDoPacjentow($wszystkieSchematy,$wszyscyPacjenci);
    }
}
