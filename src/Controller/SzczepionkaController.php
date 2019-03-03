<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Szczepionka;

class SzczepionkaController extends AbstractController
{
    /**
     * @Route("/szczepionka", name="szczepionka")
     */
    public function index()
    {
        return $this->render('szczepionka/index.html.twig', [
            'controller_name' => 'SzczepionkaController',
        ]);
    }
    /**
     * @Route("/szczepionka/nowa",name="szczepionkanowa")
     */
     public function nowa(Request $request)
     {
         $nowaSzczepionka = new Szczepionka();
         $nowaSzczepionka->setCzyZywa(false);
         $nowaSzczepionka->setCzyObowiazkowa(true);
         //$nowaSzczepionka->setZastepujeSzczepionke();
         $nowaSzczepionka->setWiekMin(12);
         $nowaSzczepionka->setWiekMax(65);
         $nowaSzczepionka->setNazwa('nazwa handlowa');
         $nowaSzczepionka->setProducent('mieszalnia osiedlowa');
         //$nowaSzczepionka->setSzczepKtoreChorobies;
         
         $formularz  = $this->createFormBuilder($nowaSzczepionka)
            ->add('nazwa',TextType::class)
            ->add('producent',TextType::class)
            ->add('wiekMin',IntegerType::class,['label' => 'Wiek minimalny'])
            ->add('wiekMax',IntegerType::class,['label' => 'Wiek maksymalny'])
            ->add('czyObowiazkowa',ChoiceType::class,['choices' => ['tak' => true, 'nie' => false], 'label' => 'czy obowiązkowa'])
            ->add('save',SubmitType::class,['label'=> 'Dodaj'])
            ->getForm();
        
        //$formularz->handleRequest($request);
        
        return $this->render('szczepionka/nowa.html.twig',
        ['formNowaSzczepiona' => $formularz->createView(),]);
     }
}