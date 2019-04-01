<?php

namespace App\Form;

use App\Entity\Szczepienie;
use App\Entity\Pacjent;
use App\Entity\Szczepiacy;
//use App\Entity\Dawka;
//use App\Entity\Szczepionka;
//use App\Repository\SzczepionkaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;



class DatzabpacjentszczepiacyType extends AbstractType
{
    private $szczepienie;
    
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            //$logger = new Logger('Mateusz');
            //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
            //$logger->warning('Przed builder ^_^ ');
            
            $builder
            ->add('dataZabiegu')//,null,[function(Szczepienie $sc){ return $sc->getDataZabiegu();},]
            ->add('pacjent',EntityType::class,[
            'class' => Pacjent::class, 
            'choice_label' => function(Pacjent $pc){return $pc->getImieInazwisko();} ])
            ->add('szczepiacy',EntityType::class,[
            'class' => Szczepiacy::class, 
            'choice_label' => function(Szczepiacy $sc){return $sc->getImieInazwisko();} ])
            ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
        ]);
        //$resolver->setRequired('dataZabiegu');
    }
}
