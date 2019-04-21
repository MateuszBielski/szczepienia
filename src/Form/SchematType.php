<?php

namespace App\Form;

use App\Entity\Schemat;
use App\Entity\Szczepionka;
use App\Entity\Dawka;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchematType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $zainicjujDawke = function(){
            $interwalInicjujacy = new \DateInterval("P89D");
            $dawkaInicjujaca = new Dawka;
            $dawkaInicjujaca->setOdstepMinInterval($interwalInicjujacy);
            $dawkaInicjujaca->setOdstepMaxInterval($interwalInicjujacy);
            $dawkaInicjujaca->setWiekPodaniaMin($interwalInicjujacy);
            $dawkaInicjujaca->setWiekPodaniaMax($interwalInicjujacy); 
            return $dawkaInicjujaca;
        };
        */
        
        $builder
            ->add('podawania',EntityType::class,[
            'class' => Szczepionka::class,
            'choice_label' => 'nazwa',//zmienić na funkcję (nazwa + choroby + producent)
            ])
            ->add('dawki',CollectionType::class,[
            'entry_type' => DawkaType::class,
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
