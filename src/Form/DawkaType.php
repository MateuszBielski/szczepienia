<?php

namespace App\Form;

use App\Entity\Dawka;
use App\Entity\Schemat;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DawkaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $opcje = function($etykieta){
            return ['label' => $etykieta,
            'with_days' => false,'with_months' => false,
            'with_weeks' => true,'labels' => [
            'years' => 'lata',
            'weeks' => 'tygodnie',]
            ];
        };
                    
        
        $builder
            ->add('odstep_min_interval',null,$opcje('odstęp minimalny'))//
            ->add('odstep_max_interval',null,$opcje('odstęp maksymalny'))
            ->add('wiekPodaniaMin',null,$opcje('minimalny wiek podania'))
            ->add('wiekPodaniaMax',null,$opcje('maksymalny wiek podania'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
        ]);
    }
}
