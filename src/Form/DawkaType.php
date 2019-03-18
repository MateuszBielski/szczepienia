<?php

namespace App\Form;

use App\Entity\Dawka;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('schemat',TextType::class,['data' => 'abcdef',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
        ]);
    }
}
