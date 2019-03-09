<?php

namespace App\Form;

use App\Entity\Grupa;
use App\Entity\Uzytkownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class Grupa1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa');
            //->add('users')
        $builder->add('users', CollectionType::class, [
          'entry_type' => UzytkownikType::class,
          'entry_options' => ['label' => false],
              'allow_add' => true,
        ]);
        //poniże nie chce działać
        //add('groups',EntityType::class,['class' => Uzytkownik::class,
        //    'choice_label' => 'nazwa',
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grupa::class,
        ]);
    }
}
