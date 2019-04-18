<?php

namespace App\Form;

use App\Entity\Choroba;
use App\Form\DataMapper\mapChorobaNazwa;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChorobaEtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('nazwa',null,['label' => 'nazwa choroby',])
            ->add('nazwa',EntityType::class,[
            'class' => Choroba::class,
            'choice_label' => 'nazwa',
            ])
            ->setDataMapper(new mapChorobaNazwa())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Choroba::class,
            'empty_data' => null,
        ]);
    }
}


