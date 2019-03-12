<?php

namespace App\Form;

use App\Entity\Grupa;
use App\Entity\Uzytkownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrupaEtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa');
            //->add('users')
        $builder->add('users', EntityType::class, [
          'class' => Uzytkownik::class,
          'choice_label' => 'imie',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grupa::class,
        ]);
    }
}
