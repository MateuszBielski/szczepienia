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
        $builder
            ->add('odstep_min_interval',null,['label' => 'odstęp minimalny',
                    'with_days' => false,'labels' => [
                    'years' => 'lata',
                    'months' => 'miesiące',]
            ])//
            ->add('odstep_max_interval',null,['label' => 'odstęp maksymalny',
                    'with_days' => false,'labels' => [
                    'years' => 'lata',
                    'months' => 'miesiące',]
                    ])
            ->add('wiekPodaniaMin',null,['label' => 'minimalny wiek podania',
                    'with_days' => false,'labels' => [
                    'years' => 'lata',
                    'months' => 'miesiące',]
                    ])
            ->add('wiekPodaniaMax',null,['label' => 'maksymalny wiek podania',
                    'with_days' => false,'labels' => [
                    'years' => 'lata',
                    'months' => 'miesiące',]
                    ])
            //->add('schemat',TextType::class,['data' => 'abcdef',])
            //->add('schemat',EntityType::class,['class' => Schemat::class,
            //'choice_label' => 'id',//zmienić na funkcję (nazwa + choroby + producent)
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
        ]);
    }
}
