<?php

namespace App\Form\DataMapper;

use App\Entity\Schemat;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

final class mapDateYear implements DataMapperInterface
{
    /**
     * @param Schemat|null $data
     */
    public function mapDataToForms($data, $forms)
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $data) {
            return;
        }

        // invalid data type
        if (!$data instanceof Schemat) {
            throw new UnexpectedTypeException($data, Schemat::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms['startYear']->setData($data->getStartYear()->format('Y'));
        
        /*
        // initialize form field values
        $forms['red']->setData($data->getRed());
        $forms['green']->setData($data->getGreen());
        $forms['blue']->setData($data->getBlue());
         */
    }

    public function mapFormsToData($forms, &$data)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // as data is passed by reference, overriding it will change it in
        // the form object as well
        // beware of type inconsistency, see caution below
        //$data = new Choroba();
        $year = $forms['startYear']->getData();
        $data->setStartYear(new \DateTime("$year-01-01"));
        /*
         $data = new Color(
            $forms['red']->getData(),
            $forms['green']->getData(),
            $forms['blue']->getData()
        );
         * */
        
    }
}

/*zapas

     * @param \Date|null $data
     *
    public function mapDataToForms($data, $forms)
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $data) {
            return;
        }

        // invalid data type
        if (!$data instanceof \Date) {
            throw new UnexpectedTypeException($data, Date::class);
        }

        /** @var FormInterface[] $forms *
        $forms = iterator_to_array($forms);
        $forms['startYear']->setData($data->format('yyyy'));
        
        /*
        // initialize form field values
        $forms['red']->setData($data->getRed());
        $forms['green']->setData($data->getGreen());
        $forms['blue']->setData($data->getBlue());
         
    }

    public function mapFormsToData($forms, &$data)
    {
         @var FormInterface[] $forms 
        $forms = iterator_to_array($forms);

        // as data is passed by reference, overriding it will change it in
        // the form object as well
        // beware of type inconsistency, see caution below
        //$data = new Choroba();
        $year = $forms['startYear']->getData();
        $data = new \Date("$year-01-01");
        /*
         $data = new Color(
            $forms['red']->getData(),
            $forms['green']->getData(),
            $forms['blue']->getData()
        );
         * 
        
    }
*/