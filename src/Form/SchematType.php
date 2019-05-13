<?php

namespace App\Form;

use App\Entity\Schemat;
use App\Entity\Szczepionka;
use App\Entity\Dawka;
use App\Repository\SchematRepository;
//use App\Form\SchematYearType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchematType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
          $idVaccine =  $builder->getData()->getPodawania()->getId();
          $idSchemat = $builder->getData()->getId();
          $builder
            ->add('podawania',EntityType::class,[
            'class' => Szczepionka::class,
            'choice_label' => 'nazwa',//zmienić na funkcję (nazwa + choroby + producent)
            //'block_name' => 'blockNamePodawania',
            ])

            ->add('startYear',SchematYearType::class,[
            ])
            //->setDataMapper(new mapDateYear())
            ->add('substitute',EntityType::class,['class' => Schemat::class,
            'label' => 'zastępuje',
            'choice_label' => function(Schemat $sc){return $sc->getVaccineNameAndStartYear();},
            'required' => false,
            'placeholder' => ' - ',
            'query_builder' => function (SchematRepository $sr) use ($idVaccine,$idSchemat) {
                    return $sr->createQueryBuilder('sch')
                        ->leftJoin('sch.podawania', 'scz')
                        ->andWhere('scz.id = :idVaccine')
                        ->andWhere('sch.id != :idSchemat')
                        ->setParameter('idVaccine', $idVaccine )
                        ->setParameter('idSchemat', $idSchemat);
                        
                },
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
            //'schematId' => null,
        ]);
        //->setRequired('dawka_inicjujaca');
    }
}
