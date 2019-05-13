<?php

namespace App\Form;

use App\Entity\KalendarzSzczepien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KalendarzSzczepienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('pacjent')
            ->add('szczepieniaUtrwalone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KalendarzSzczepien::class,
        ]);
    }
}
