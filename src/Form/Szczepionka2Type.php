<?php

namespace App\Form;

use App\Entity\Szczepionka2;
use App\Entity\Choroba;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Szczepionka2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa')
            ->add('producent')
            ->add('wiekMin')
            ->add('wiekMax')
            ->add('czyObowiazkowa')
            ->add('zastepuje')
            ->add('przeciw',EntityType::class,['class' => Choroba::class,
            'choice_label' => 'nazwa',]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepionka2::class,
        ]);
    }
}