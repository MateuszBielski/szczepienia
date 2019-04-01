<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Form\DatzabpacjentszczepiacyType;
use App\Form\CopodanoType;
use Symfony\Component\Form\AbstractType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;



class SzczepienieType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            //$logger = new Logger('Mateusz');
            //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
            //$logger->warning('Przed builder ^_^ ');
            
            $builder
            ->add('datZabpacjentszczepiacy',DatzabpacjentszczepiacyType::class)//,null,[function(Szczepienie $sc){ return $sc->getDataZabiegu();},]
            ->add('coPodano',CopodanoType::class)
            
            ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Szczepienie::class,
        ]);
        //$resolver->setRequired('dataZabiegu');
    }
}
