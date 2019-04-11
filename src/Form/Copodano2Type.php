<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
use App\Entity\Schemat;
use App\Entity\Dawka;
use App\Entity\Szczepionka;
use App\Ropository\SzczepionkaRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;



class Copodano2Type extends AbstractType
{
    private $szczepienie;
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            $logger = new Logger('Mateusz');
            $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
            $logger->warning('Przed builder ^_^ ');
            
            $builder
            ->add('dataZabiegu')//
            ->add('pacjent',EntityType::class,[
            'class' => Pacjent::class, 
            'choice_label' => function(Pacjent $pc){return $pc->getImieInazwisko();} ])
            ->add('szczepiacy',EntityType::class,[
            'class' => Szczepiacy::class, 
            'choice_label' => function(Szczepiacy $sc){return $sc->getImieInazwisko();} ])
            ->add('rodzajSzczepionki',EntityType::class,[
            'class' => Szczepionka::class,
            'choice_label' => 'nazwa'
            ])
            ->add('schematTymczasowy', EntityType::class, [
                'class' => Schemat::class,
                
                'choice_label' => 'id',
                'label' => 'schemat',
            ])
            
            ->add('coPodano', EntityType::class, [
                'class' => Dawka::class,
                //'choices' => $mozliweDawki,
                'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
            ])
        ;
        
        $dodajPoleSchemat = function  (FormInterface $formularz,Szczepionka $szczepionka)
        {
            $mozliweSchematy = (null == $szczepionka) ? [] : $szczepionka->getSchematy();
            $formularz->add('schematTymczasowy', EntityType::class, [
                'class' => Schemat::class,
                'choices' => $mozliweSchematy,
                'choice_label' => 'id',
                'label' => 'schemat',
            ])  
            ;
        };
        $dodajPoleCoPodano = function (FormInterface $formularz,Collection $mozliweDawki = null) {
            //$mozliweDawki = (null == $schemat) ? [] : $schemat->getDawki();
            $formularz->add('coPodano', EntityType::class, [
                'class' => Dawka::class,
                'choices' => $mozliweDawki,
                'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
            ]);
        };
        
        //$propozycjaDawki = $options['propozycjaDawki'];
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($dodajPoleSchemat,$dodajPoleCoPodano) {//,$propozycjaDawki
                $szczepienie = $event->getData();
                //$szczepienie->setCoPodano($propozycjaDawki);
                //$dataZab = new \DateTime;
                //$szczepienie->setDataZabiegu($dataZab);
                $szczepionka = $szczepienie->getRodzajSzczepionki();
                $dodajPoleSchemat($event->getForm(), $szczepionka);
                $schemat = $szczepienie->getSchematTymczasowy();
                $dodajPoleCoPodano($event->getForm(),$schemat->getDawki());
            }
        );
        
        //$schRep = $options['schRep'];
        
        //$saRep = $options['saRep'];
        /*
         $builder->get('rodzajSzczepionki')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($dodajPoleSchemat,$dodajPoleCoPodano) {
                $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
                $szczepionka = $event->getForm()->getData();
                $formularz = $event->getForm()->getParent();
                //$szczepienie = $formularz->getData();
                //$szczepienie->setRodzajSzczepionki($szczepionka);
                $tekst = 'pusta';
                if(!($szczepionka == null)){
                    $tekst = $szczepionka->getId();
                    //$szczepionka = $saRep->find($szczepionkaId);
                    $dodajPoleSchemat($formularz,$szczepionka);
                    //$dodajPoleCoPodano($formularz,$szczepionka->getDostepneDawki());
                }
                 $logger->warning('PRE_SUBMIT szczepionkaId: '.$tekst);
            }
        );
        */
        
        $builder->get('schematTymczasowy')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($dodajPoleCoPodano) {
                 $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
                $schemat = $event->getForm()->getData();
                //$schematId = array_key_exists('schematTymczasowy', $odpowiedz) ? $odpowiedz['schematTymczasowy'] : null;
                
                $tekst = 'pusta';
                if(!($schemat == null)){
                    $tekst = $schemat->getId();
                    //$schemat = $schRep->find($schematId);
                    $dodajPoleCoPodano($event->getForm()->getParent(),$schemat->getDawki());
                }
                 $logger->warning('POST_SUBMIT schematId: '.$tekst);
                
                //
                
                
                //$data = $event->getData();
                //$facility_id = array_key_exists('facility', $data) ? $data['facility'] : null;
                //$addFacilityStatuscodeForm($event->getForm(), $facility_id);
            }
        );
        
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
            'saRep' => null,
            'schRep' => null,
            'propozycjaDawki' => null,
        ]);
    }
}
