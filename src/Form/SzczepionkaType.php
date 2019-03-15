<?php

namespace App\Form;

use App\Entity\Szczepionka;
use App\Entity\Choroba;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SzczepionkaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('czyZywa',null,['label' => 'czy żywa'])
            ->add('czyObowiazkowa')
            ->add('zastepujeSzczepionke')
            ->add('wiekMin')
            ->add('wiekMax')
            ->add('nazwa')
            ->add('producent')
            ->add('przeciw',EntityType::class,[
            'class' => Choroba::class,
            'choice_label' => 'nazwa',
            'label' => 'przeciw'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Szczepionka::class,
        ]);
    }
}
