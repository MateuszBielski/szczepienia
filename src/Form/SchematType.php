<?php

namespace App\Form;

use App\Entity\Schemat;
use App\Entity\Szczepionka;
use App\Entity\Dawka;
use App\Form\DataMapper\mapDateYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchematType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('podawania',EntityType::class,[
            'class' => Szczepionka::class,
            'choice_label' => 'nazwa',//zmienić na funkcję (nazwa + choroby + producent)
            //'block_name' => 'blockNamePodawania',
            ])

            ->add('startYear',TextType::class,['label' => 'obowiązuje od początku roku',//BirthdayType::class
            //'format' => 'd-M-yyyy'
            //'widget' => 'single_text'
            ])
            ->setDataMapper(new mapDateYear())
            ->add('substitute',EntityType::class,['class' => Schemat::class,
            'label' => 'zastępuje',
            'choice_label' => function(Schemat $sc){return $sc->getVaccineNameAndStartYear();},
            'placeholder' => ' - ',
            ])
            ->add('dawki',CollectionType::class,[
            'entry_type' => DawkaType::class,
            //'entry_options' => ['attr' => ['width' => '22%', 'float' => 'left']],
            'allow_add' => true,
            'allow_delete' =>true,
            'by_reference' =>true,
            'prototype_data' => $options['prototype_data_opt'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schemat::class,
            'prototype_data_opt' => null,
        ]);
        //->setRequired('dawka_inicjujaca');
    }
}
