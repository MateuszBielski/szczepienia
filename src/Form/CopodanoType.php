<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
use App\Entity\Dawka;
use App\Entity\Szczepionka;
use App\Repository\SzczepionkaRepository;
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
           
            //$logger = new Logger('Mateusz');
            //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
            //$logger->warning('Przed builder ^_^ ');
            
            $builder
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
            $mozliweDawki = null === $szczepionka ? [] : $szczepionka->getDostepneDawki();
            $form->add('coPodano', EntityType::class, [
                'class' => 'App\Entity\Dawka',
                'choices' => $mozliweDawki,
                'choice_label' => 'odstepMax',
            ]);
            /*
            $form->get('dataZabiegu')->setData($options['dataZabiegu']);
            $logger = new Logger('Mateusz');
            $logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
            $komunikat = 'pusty';
            //if($szczepionka)
            {
                $komunikat =' nr szczepionki '.$szczepionka->getId();
            }
            //$datazbiegu = ' datazabiegu '.$form->get('dataZabiegu')->getData();
            $dataZabiegu = $szczepienie->getDataZabiegu()->format('d-m-Y');
            
            $logger->warning('FormModifier'.$komunikat.'dataZabZeSzczepienia'.$dataZabiegu);
             */
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                //skąd wiadomo, że event dotyczy pola rodzaj szczepionki - wcale nie dotyczy, bo to jest cały obiekt
                // to jest obiekt szczepienie
                $szczepienie = $event->getData();
                //$logger = new Logger('Mateusz');
                //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
                //$logger->warning('builder->addEventListener'.$szczepienie->getDataZabiegu()->format('d-m-Y'));
                
                //$event->getForm()->get('dataZabiegu')->setData($szczepienie->getDataZabiegu());
                //$datZabZformularza = $event->getForm()->get('dataZabiegu')->getData()->format('d-m-Y');
                
                
                $formModifier($event->getForm(), $szczepienie->getRodzajSzczepionki());
                //$logger->warning('builder->addEventListener po form modifier'.$datZabZformularza);
            }
        );
        
        
         
         $builder->get('rodzajSzczepionki')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $szczepionka = $event->getForm()->getData();
                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                //$logger = new Logger('Mateusz');
                //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
               
                $szczepienie = $event->getForm()->getParent()->getData();
                //$logger->warning('builder->getRodzajSzczepionki'.$szczepienie->getDataZabiegu()->format('d-m-Y'));
                
                //$datZabZformularza = 'brak';
                //$datZabZformularza = $event->getForm()->getParent()->get('dataZabiegu')->getData()->format('d-m-Y');
                
                $formModifier($event->getForm()->getParent(), $szczepionka);//
                //$event->setData($szczepienie->getDataZabiegu());
                //$logger->warning('builder->getRodzajSzczepionki po form modifier, data z formularza'.$datZabZformularza);
            }
        );
        
        //$logger->warning('Koniec BuildForm'); 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
        ]);
    }
}
