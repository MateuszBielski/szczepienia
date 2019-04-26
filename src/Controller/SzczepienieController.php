<?php

namespace App\Controller;

use App\Entity\Szczepienie;
use App\Entity\Szczepionka;
use App\Entity\Dawka;
use App\Entity\Schemat;
use App\Entity\Pacjent;
use App\Form\SzczepienieType;
use App\Form\CopodanoType;
use App\Repository\SzczepienieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * @Route("/szczepienie")
 */
class SzczepienieController extends AbstractController
{
    
    //private $propozycjaDawki;

    /**
     * @Route("/", name="szczepienie_index", methods={"GET"})
     */
    public function index(SzczepienieRepository $szczepienieRepository): Response
    {
        return $this->render('szczepienie/index.html.twig', [
            'szczepienies' => $szczepienieRepository->findAll(),
        ]);
    }
    
    public function zaproponujDawke()
    {
        //$szczepionkaPierwszaZlisty = $this->getDoctrine()->getRepository(Szczepionka::class)->znajdzPierwszaZlisty();
        $szczepionkaOstatniaZlisty = $this->getDoctrine()->getRepository(Szczepionka::class)->znajdzOstatniaZlisty();
        //if(!count($szczepionkaOstatniaZlisty->getSchematy()))return false;
        return  $this->getDoctrine()->getRepository(Dawka::class)->znajdzWgSzczepionki($szczepionkaOstatniaZlisty);
        
    }
    /**
     * @Route("/ajaxDawkaZeSchematu", name="ajaxDawkaZeSchematu", methods={"GET"})
     */
    public function ajaxDawkaZeSchematu(Request $request)
    {
        
        $schematId = $request->query->get("schematId");
        $schemat = $this->getDoctrine()->getRepository(Schemat::class)->find($schematId);
        $dawki = $schemat->getDawki();
        $responseArray = array();
        foreach($dawki as $dawka){
            $responseArray[] = array(
                "id" => $dawka->getId(),
                "nazwa" => $dawka->getSkroconeCechyMojeImojejSzczepionki(),
            );
        }
        
        return new JsonResponse($responseArray);
    }
    
    /**
     * @Route("/ajaxSchematZeSczepionki", name="ajaxSchematZeSczepionki", methods={"GET"})
     */
    public function ajaxSchematZeSczepionki(Request $request)
    {
        
        $szczepionkaId = $request->query->get("szczepionkaId");
        $szczepionka = $this->getDoctrine()->getRepository(Szczepionka::class)->find($szczepionkaId);
        $schematy = $szczepionka->getSchematy();
        $responseArray = array();
        foreach($schematy as $schemat){
            $responseArray[] = array(
                "id" => $schemat->getId(),
                //"name" => $neighborhood->getName()
            );
        }
        
        return new JsonResponse($responseArray);
    }
    /**
     * @Route("/new/{pacjent}", name="szczepienie_new", methods={"GET","POST"})
     */
    public function new(Request $request, Pacjent $pacjent = null): Response
    {
        $szczepienie = new Szczepienie();
        if($pacjent != null)$szczepienie->setPacjent($pacjent);
        
        $propozycjaDawki = $this->zaproponujDawke();
        $szczepienie->setCoPodano($propozycjaDawki);
        
        $schemat = $propozycjaDawki->getSchemat();
        $szczepienie->setSchematTymczasowy($schemat);
        
        $szczepionka = $schemat->getPodawania();
        $szczepienie->setRodzajSzczepionki($szczepionka);
        
        $dataZab = new \DateTime;
        $szczepienie->setDataZabiegu($dataZab);
        
        $saRep = $this->getDoctrine()->getRepository(Szczepionka::class);
        $schRep = $this->getDoctrine()->getRepository(Schemat::class);
        $form = $this->createForm(CopodanoType::class, $szczepienie);//,array('saRep' => $saRep,'schRep' => $schRep, 'propozycjaDawki' => $propozycjaDawki)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) 
        { 
            $dataOdczytana = $form->get('dataZabiegu')->getData();
            $szczepienie->setDataZabiegu($dataOdczytana);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($szczepienie);
            $entityManager->flush();

            $route = 'szczepienie_index';
            $routeParam = array();
            if($pacjent){
                $route = 'pacjent_show';
                $routeParam = ['id' => $pacjent->getId(),];
            }
            return $this->redirectToRoute($route,$routeParam);
        }

        return $this->render('szczepienie/new.html.twig', [
            'szczepienie' => $szczepienie,
            'form' => $form->createView(),
            //'formCoPodano' => $formCoPodano->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepienie_show", methods={"GET"})
     */
    public function show(Szczepienie $szczepienie): Response
    {
        return $this->render('szczepienie/show.html.twig', [
            'szczepienie' => $szczepienie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="szczepienie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Szczepienie $szczepienie): Response
    {
        $form = $this->createForm(CopodanoType::class, $szczepienie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pacjent_show', [
                'id' => $szczepienie->getPacjent()->getId(),
            ]);
        }

        return $this->render('szczepienie/edit.html.twig', [
            'szczepienie' => $szczepienie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="szczepienie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Szczepienie $szczepienie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$szczepienie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($szczepienie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('szczepienie_index');
    }
    
}
