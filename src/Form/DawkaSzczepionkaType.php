<?php

namespace App\Form;

use App\Entity\Dawka;
use App\Entity\Szczepionka;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DawkaSzczepionkaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('odstepMin',null,['label' => 'minimalny'])//
            //->add('odstepMax',null,['label' => 'maksymalny'])
            //->add('schemat',TextType::class,['data' => 'abcdef',])
            ->add('schemat',EntityType::class,['class' => Szczepionka::class,
            'choice_label' => 'nazwa',//zmienić na funkcję (nazwa + choroby + producent)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dawka::class,
        ]);
    }
}
