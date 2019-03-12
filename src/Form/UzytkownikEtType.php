<?php

namespace App\Form;

use App\Entity\Uzytkownik;
use App\Entity\Telefon;
use App\Entity\Grupa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UzytkownikEtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie',TextType::class,['label' => 'imię']);
            
        $builder->add('telefons', EntityType::class, [
          'class' => Telefon::class,//?TelefonType - sprawdzić
          'choice_label' => 'numer',
          'label' => 'telefony',
            /*'choice_label' => function(Telefon $gr) {
                return sprintf('(%d) %s', $gr->getId(), $gr->getNazwa());
            },*/
          //'placeholder' => 'Grupy nie ma na liście',
          //'expanded' => true,
          //'multiple' => true,
        ]);
        $builder->add('groups',EntityType::class,[
        'class' => Grupa::class,
        'choice_label' => 'nazwa',
        'label' => 'grupy',]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Uzytkownik::class,
        ]);
    }
}
