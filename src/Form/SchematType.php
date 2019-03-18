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
        $builder
            ->add('podawania',EntityType::class,[
            'class' => Szczepionka::class,
            'choice_label' => 'nazwa',//zmienić na funkcję (nazwa + choroby + producent)
            ])
            /*
            ->add('dawki',CollectionType::class, [
              'entry_type' => EntityType::class,
              'entry_options' => [
                'class' => Dawka::class,
                'choice_label' => 'id',
                //'attr' => ['class' => 'klasaPrzeciw'],
                ],
            'allow_add' => true,
            'allow_delete' =>true,
            'by_reference' =>true,
            ])
             */
            ->add('dawki',CollectionType::class,[
            'entry_type' => DawkaType::class,
            'allow_add' => true,
            'allow_delete' =>true,
            'by_reference' =>true,
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
