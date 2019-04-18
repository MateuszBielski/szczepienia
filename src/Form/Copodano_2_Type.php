<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
use App\Entity\Schemat;
use App\Entity\Dawka;
use App\Entity\Szczepionka;
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



class Copodano_2_Type extends AbstractType
{
    private $szczepienie;
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            $logger = new Logger('Mateusz');
            $logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
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
        $formModifier = function (FormInterface $form, Szczepionka $szczepionka = null) {
            $nieWybranaSzczepionka = (null === $szczepionka);
            $mozliweDawki = $nieWybranaSzczepionka ? [] : $szczepionka->getDostepneDawki();
            $mozliweSchematy = $nieWybranaSzczepionka ? [] : $szczepionka->getSchematy();
            $form
                ->add('coPodano', EntityType::class, [
                'class' => Dawka::class,
                'choices' => $mozliweDawki,
                'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
            ])
              ->add('schematTymczasowy', EntityType::class, [
                'class' => Schemat::class,
                'choices' => $mozliweSchematy,
                'choice_label' => 'id',
                'label' => 'schemat',
            ])  
            ;
            
            
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $szczepienie = $event->getData();
                $formModifier($event->getForm(), $szczepienie->getRodzajSzczepionki());
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $szczepienie = $event->getData();
                //$park_id = array_key_exists('park', $data) ? $data['park'] : null;
                $addFacilityForm($event->getForm(), $szczepienie);
            }
        );
        
        //ustalenie schematu
        $builder->get('rodzajSzczepionki')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $szczepionka = $event->getForm()->getData();
                $formularzGlowny = $event->getForm()->getParent();
                $formModifier($formularzGlowny, $szczepionka);
                $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
                $logger->warning('ustalenie schematu');
            
            }
        );
        //ustalenie dawki ze schematu
        /*
        $builder->get('schematTymczasowy')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $schemat = $event->getForm()->getData();
                $formularzGlowny = $event->getForm()->getParent();
                $nieWybranySchemat = (null === $schemat);
                $mozliweDawki = $nieWybranySchemat ? [] : $szczepionka->getDawki();
                $formularzGlowny
                    ->add('coPodano', EntityType::class, [
                    'class' => Dawka::class,
                    'choices' => $mozliweDawki,
                    'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
                ]);
            }
        );
        /*
         /* *******to działało w wersji bez schematu
         $builder->get('rodzajSzczepionki')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $szczepionka = $event->getForm()->getData();
               
                $formularzGlowny = $event->getForm()->getParent();
                
                $formModifier($formularzGlowny, $szczepionka);
                //$logger = new Logger('Mateusz');
                //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
                //$komunikat = 'brak pola zabiegu';
                //if($formularzGlowny->has('dataZabiegu'))$komunikat = 'pole zabiegu nadal istnieje';
                
                //$logger->warning('get(rodzajSzczepionki)'.$komunikat);
            }
        );
        */
    }
 /*    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('park', 'entity', array(
                'class' => 'AppBundle:Park',
                'property' => 'identifyingName',
                'label' => 'Park',
                'required' => true,
                'invalid_message' => 'Choose a Park',
                'placeholder' => 'Please choose',
            ))
            // other fields
        ;

        $addFacilityForm = function (FormInterface $form, $park_id) {
            // it would be easier to use a Park entity here,
            // but it's not trivial to get it in the PRE_SUBMIT events
            $form->add('facility', 'entity', array(
                'class' => 'AppBundle:Facility',
                'property' => 'identifyingName',
                'label' => 'Facility',
                'required' => true,
                'invalid_message' => 'Choose a Facility',
                'placeholder' => null === $park_id ? 'Please choose a Park first' : 'Please Choose',
                'query_builder' => function (FacilityRepository $repository) use ($park_id) {
                    // this does the trick to get the right options
                    return $repository->createQueryBuilder('f')
                        ->innerJoin('f.park', 'p')
                        ->where('p.id = :park')
                        ->setParameter('park', $park_id)
                    ;
                }
            ));
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addFacilityForm) {
                $park = $event->getData()->getPark();
                $park_id = $park ? $park->getId() : null;
                $addFacilityForm($event->getForm(), $park_id);
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addFacilityForm) {
                $data = $event->getData();
                $park_id = array_key_exists('park', $data) ? $data['park'] : null;
                $addFacilityForm($event->getForm(), $park_id);
            }
        );

        $addFacilityStatuscodeForm = function (FormInterface $form, $facility_id) {
            $form->add('facilityStatuscode', 'entity', array(
                'class' => 'AppBundle:FacilityStatuscode',
                'property' => 'identifyingName',
                'label' => 'Statuscode',
                'required' => true,
                'invalid_message' => 'Choose a Statuscode',
                'placeholder' => null === $facility_id ? 'Please choose a Facility first' : 'Please Chosse',
                'query_builder' => function (FacilityStatuscodeRepository $repository) use ($facility_id) {
                    // a bit more complicated, that's how this model works
                    return $repository->createQueryBuilder('fs')
                        ->innerJoin('fs.facilityStatuscodeType', 'fst')
                        ->innerJoin('AppBundle:Facility', 'f', 'WITH', 'f.facilityStatuscodeType = fst.id')
                        ->where('f.id = :facility_id')
                        ->setParameter('facility_id', $facility_id)
                    ;
                }
            ));
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addFacilityStatuscodeForm) {
                $facility = $event->getData()->getFacility();
                $facility_id = $facility ? $facility->getId() : null;
                $addFacilityStatuscodeForm($event->getForm(), $facility_id);
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addFacilityStatuscodeForm) {
                $data = $event->getData();
                $facility_id = array_key_exists('facility', $data) ? $data['facility'] : null;
                $addFacilityStatuscodeForm($event->getForm(), $facility_id);
            }
        );


    }
*/
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
        ]);
    }
}
