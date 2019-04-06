<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
use App\Entity\Schemat;
use App\Entity\Dawka;
use App\Entity\Szczepionka;
use App\Ropository\SzczepionkaRepository;
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



class CopodanoType extends AbstractType
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
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($dodajPoleSchemat) {
                $szczepienie = $event->getData();
                $dodajPoleSchemat($event->getForm(), $szczepienie->getRodzajSzczepionki());
                //$park = $event->getData()->getPark();
                //$park_id = $park ? $park->getId() : null;
                //$addFacilityForm($event->getForm(), $park_id);
            }
        );
        $saRep = $options['saRep'];
         $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($dodajPoleSchemat,$saRep) {
                $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
                $odpowiedz = $event->getData();
                $szczepionkaId = array_key_exists('rodzajSzczepionki', $odpowiedz) ? $odpowiedz['rodzajSzczepionki'] : null;
                $logger->warning('PRE_SUBMIT rodzajSzczepionki: '.$szczepionkaId); 
                $szczepionka = $saRep->find($szczepionkaId);
                $dodajPoleSchemat($event->getForm(),$szczepionka);
                
                /**********tu jeszcze dodać wypełnienie dla pola coPodano*******/
                
                //$data = $event->getData();
                //$park_id = array_key_exists('park', $data) ? $data['park'] : null;
                //$addFacilityForm($event->getForm(), $park_id);
            }
        );
        $dodajPoleCoPodano = function (FormInterface $formularz,Schemat $schemat = null) {
            $mozliweDawki = (null == $schemat) ? [] : $schemat->getDawki();
            $formularz->add('coPodano', EntityType::class, [
                'class' => Dawka::class,
                'choices' => $mozliweDawki,
                'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($dodajPoleCoPodano) {
                $szczepienie = $event->getData();
                $dodajPoleCoPodano($event->getForm(),$szczepienie->getSchematTymczasowy());
                //$facility = $event->getData()->getFacility();
                //$facility_id = $facility ? $facility->getId() : null;
                //$addFacilityStatuscodeForm($event->getForm(), $facility_id);
            }
        );
        $schRep = $options['schRep'];
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($dodajPoleCoPodano,$schRep) {
                 $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
                $odpowiedz = $event->getData();
                $schematId = array_key_exists('schematTymczasowy', $odpowiedz) ? $odpowiedz['schematTymczasowy'] : null;
                $logger->warning('PRE_SUBMIT schematId: '.$schematId); 
                
                $schemat = $schRep->find($schematId);
                $dodajPoleCoPodano($event->getForm(),$schemat);
                
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
        ]);
    }
}
