<?php

namespace App\Form;

//use Doctrine\Common\Persistence\ObjectManager;
use App\Form\DataTransformer\DateYearStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchematYearType extends AbstractType
{
    private $transformer;

    public function __construct(DateYearStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'invalid_message' => 'The selected issue does not exist',
            'label' => 'obowiązuje od początku roku',//BirthdayType::class
            'choices' => range(1980,2020),
            'choice_label' => function ($choice, $key, $value){ return $value; },
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}