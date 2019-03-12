<?php

namespace App\Form;

use App\Entity\Telefon;
use App\Entity\Uzytkownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelefonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numer')
            ->add('wlasciciel',EntityType::class,
            ['class' => Uzytkownik::class,
            'choice_label' => 'imie',]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Telefon::class,
        ]);
    }
}
