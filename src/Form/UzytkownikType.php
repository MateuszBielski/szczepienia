<?php

namespace App\Form;

use App\Entity\Uzytkownik;
use App\Entity\Grupa;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UzytkownikType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie')
            ->add('groups',EntityType::class,['class' => Grupa::class,
            'choice_label' => 'nazwa',
            'by_reference' => false,])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Uzytkownik::class,
        ]);
    }
}
