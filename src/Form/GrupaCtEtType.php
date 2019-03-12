<?php

namespace App\Form;

use App\Entity\Grupa;
use App\Entity\Uzytkownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GrupaCtEtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa');
            //->add('users')
        $builder->add('groups', CollectionType::class, [
          'entry_type' => GrupaEtType::class,
          'allow_add' => true,
          'allow_delete' =>true,
          //'prototype' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grupa::class,
        ]);
    }
}
