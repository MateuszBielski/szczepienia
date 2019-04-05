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



class CopodanoType extends AbstractType
{
    private $szczepienie;
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            $logger = new Logger('Mateusz');
            $logger->pushHandler(new StreamHandler('/home/mateusz/php/sfprojects/szczepienia/var/log/dev.log', Logger::WARNING));
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
        $dodajPoleSchemat = function  (FormInterface $formularz,Szczepionka $szczepionka = null) 
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
         $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($dodajPoleSchemat) {
                $tablica = $event->getData();
                $logger = new Logger('Mateusz');
                $logger->pushHandler(new StreamHandler('/home/mateusz/php/sfprojects/szczepienia/var/log/dev.log', Logger::WARNING));
                    $logger->warning('PRE_SUBMIT typ $szczepienie: '.var_dump($tablica));
                $dodajPoleSchemat($event->getForm(), $szczepienie->getRodzajSzczepionki());
                //$data = $event->getData();
                //$park_id = array_key_exists('park', $data) ? $data['park'] : null;
                //$addFacilityForm($event->getForm(), $park_id);
            }
        );
        
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
