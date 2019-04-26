<?php

namespace App\Form;

use App\Entity\Szczepionka;
use App\Entity\Choroba;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SzczepionkaCtType extends AbstractType
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
            /*
            ->add('przeciw',EntityType::class,[
            'class' => Choroba::class,
            'choice_label' => 'nazwa',
            'label' => 'przeciw'
            ])
            ->add('przeciw', CollectionType::class, [
              'entry_type' => ChorobaEtType::class,
              'entry_options' => ['label' => false],
              'allow_add' => true,
              'allow_delete' =>true,
              'by_reference' =>true,
            ])*/
            ->add('przeciw',CollectionType::class, [
              'entry_type' => EntityType::class,
              'entry_options' => [
                'class' => Choroba::class,
                'choice_label' => 'nazwa',
                'placeholder' => '<a href="http://127.0.0.1:8001/choroba/new">dodaj chorobę</a>',
                //'attr' => ['class' => 'klasaPrzeciw'],
                ],
            'allow_add' => true,
            'allow_delete' =>true,
            'by_reference' =>true,
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
