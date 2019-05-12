<?php

namespace App\Form;

use App\Entity\Schemat;
use App\Form\DataMapper\mapDateYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchematYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('startYear',ChoiceType::class,['label' => 'obowiązuje od początku roku',
            'choices' => range(1991,2020),
            'choice_label' => function ($choice, $key, $value){ return $value; }
            ])
            ->setDataMapper(new mapDateYear());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schemat::class,
        ]);
    }
}
