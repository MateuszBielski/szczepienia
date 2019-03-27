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
use Symfony\Component\OptionsResolver\OptionsResolver;

class SzczepienieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataZabiegu')
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
            //->add('coPodano',DawkaSzczepionkaType::class,['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepienie::class,
        ]);
    }
}
