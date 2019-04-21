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



class CopodanoType extends AbstractType
{
    private $szczepienie;
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
            $logger = new Logger('Mateusz');
            $logger->pushHandler(new StreamHandler("../var/log/dev.log", Logger::WARNING));
            $logger->warning('Przed builder ^_^ ');
            
            $builder
            ->add('dataZabiegu',null,['years' => range(1901,2030)])//
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
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
            //'saRep' => null,
            //'schRep' => null,
            'propozycjaDawki' => null,
        ]);
    }
}
