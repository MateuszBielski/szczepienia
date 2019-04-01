<?php

namespace App\Controller;

use App\Entity\Szczepienie;
use App\Entity\Szczepionka;
use App\Entity\Dawka;
use App\Form\SzczepienieType;
use App\Form\CopodanoType;
use App\Repository\SzczepienieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * @Route("/szczepienie")
 */
class SzczepienieController extends AbstractController
{
    /**
     * @Route("/", name="szczepienie_index", methods={"GET"})
     */
    public function index(SzczepienieRepository $szczepienieRepository): Response
    {
        return $this->render('szczepienie/index.html.twig', [
            'szczepienies' => $szczepienieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="szczepienie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $szczepienie = new Szczepienie();
        $szczepienie->setCoPodano($this->zaproponujDawke());
        $dataZab = new \DateTime;
        $szczepienie->setDataZabiegu($dataZab);
        
        $form = $this->createForm(CopodanoType::class, $szczepienie);
        //$form = $this->createForm(SzczepienieCoPodanoType::class, $szczepienie);
        $form->handleRequest($request);
        //$formCoPodano->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) { //&& $formCoPodano->isSubmitted() && $formCoPodano->isValid()
            //$logger = new Logger('SzczepienieController');
            //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
            //$logger->warning('szczep data zabiegu'.$szczepienie->getDataZabiegu()->format('d-m-Y'));
            $dataOdczytana = $form->get('dataZabiegu')->getData();
            $szczepienie->setDataZabiegu($dataOdczytana);
            //$szczepienie->setPacjent($form->get('pacjent')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($szczepienie);
            $entityManager->flush();

            return $this->redirectToRoute('szczepienie_index');
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

            return $this->redirectToRoute('szczepienie_index', [
                'id' => $szczepienie->getId(),
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
    public function zaproponujDawke(): Dawka
    {
        //$szczepionkaPierwszaZlisty = $this->getDoctrine()->getRepository(Szczepionka::class)->znajdzPierwszaZlisty();
        $szczepionkaOstatniaZlisty = $this->getDoctrine()->getRepository(Szczepionka::class)->znajdzOstatniaZlisty();
        $dawka = $this->getDoctrine()->getRepository(Dawka::class)->znajdzWgSzczepionki($szczepionkaOstatniaZlisty);
        
        return $dawka;
    }
}
