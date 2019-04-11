<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
use App\Entity\Dawka;
use App\Entity\Schemat;
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
    //private $szczepienie;
    
    
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
            ->add('schematTymczasowy',EntityType::class,[
            'class' => Schemat::class,
            'choice_label' => 'id'
            ])
        ;
        $formModifier = function (FormInterface $form, Schemat $schemat = null) {
            $mozliweDawki = null === $schemat ? [] : $schemat->getDawki();
            $form->add('coPodano', EntityType::class, [
                'class' => Dawka::class,
                'choices' => $mozliweDawki,
                'choice_label' => function(Dawka $d){return $d->getSkroconeCechyMojeImojejSzczepionki();},
            ])
            ;
            
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $szczepienie = $event->getData();
                //$dataZformularza = $event->getForm()->get('dataZabiegu')->getData();
                $formModifier($event->getForm(), $szczepienie->getSchematTymczasowy());
            }
        );
        
         $builder->get('schematTymczasowy')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $schemat = $event->getForm()->getData();
               
                $formularzGlowny = $event->getForm()->getParent();
                
                $formModifier($formularzGlowny, $schemat);
                //$logger = new Logger('Mateusz');
                //$logger->pushHandler(new StreamHandler('../var/log/dev.log', Logger::WARNING));
                //$komunikat = 'brak pola zabiegu';
                //if($formularzGlowny->has('dataZabiegu'))$komunikat = 'pole zabiegu nadal istnieje';
                
                //$logger->warning('get(rodzajSzczepionki)'.$komunikat);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
        ]);
    }
}
