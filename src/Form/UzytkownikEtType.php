<?php

namespace App\Form;

use App\Entity\Uzytkownik;
use App\Entity\Telefon;
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
            
        $builder->add('telefons', EntityType::class, [
          'class' => Telefon::class,//?TelefonType - sprawdzić
          'choice_label' => 'numer',
            /*'choice_label' => function(Telefon $gr) {
                return sprintf('(%d) %s', $gr->getId(), $gr->getNazwa());
            },*/
          //'placeholder' => 'Grupy nie ma na liście',
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
