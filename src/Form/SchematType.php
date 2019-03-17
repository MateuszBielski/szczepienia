<?php

namespace App\Form;

use App\Entity\Schemat;
use App\Entity\Szczepionka;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schemat::class,
        ]);
    }
}
