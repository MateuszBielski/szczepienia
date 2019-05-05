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
         $opcjeTygodnie = function($etykieta){
            return ['label' => $etykieta,
            'with_days' => false,
            'with_months' => true,
            'with_weeks' => true,
            'labels' => [
            'years' => 'lata',
            'months' => 'mięsiące',
            'weeks' => 'tygodnie',],
            ];
        };
        $opcjeMiesiace = function($etykieta){
            return ['label' => $etykieta,
            'with_days' => false,
            'with_months' => true,
            'with_weeks' => false,
            'labels' => [
            'years' => 'lata',
            'months' => 'miesiące',],
            ];
        };
                    
        
        $builder
            ->add('odstep_min_interval',null,$opcjeTygodnie('odstęp minimalny'))//
            ->add('odstep_max_interval',null,$opcjeTygodnie('odstęp maksymalny'))
            ->add('wiekPodaniaMin',null,$opcjeMiesiace('minimalny wiek (rozpoczęty okres)'))
            ->add('wiekPodaniaMax',null,$opcjeMiesiace('maksymalny wiek (do ukończenia)'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
            //'attr' => ['width' => '22%', 'float' => 'left'],
        ]);
    }
}
