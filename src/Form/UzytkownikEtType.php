<?php

namespace App\Form;

use App\Entity\Uzytkownik;
use App\Entity\Grupa;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UzytkownikEtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie');
            
        $builder->add('groups', EntityType::class, [
          'class' => Grupa::class,
          'choice_label' => function(Grupa $gr) {
                    return sprintf('(%d) %s', $gr->getId(), $gr->getNazwa());
                },
          'placeholder' => 'Grupy nie ma na liście',
          //'expanded' => true,
          //'multiple' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Uzytkownik::class,
        ]);
    }
}
