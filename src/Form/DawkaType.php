<?php

namespace App\Form;

use App\Entity\Dawka;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DawkaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ktora')
            ->add('odstepMin',null,['label' => 'minimalny'])//
            ->add('odstepMax',null,['label' => 'maksymalny'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
        ]);
    }
}
