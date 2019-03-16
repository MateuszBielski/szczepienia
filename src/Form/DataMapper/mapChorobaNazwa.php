<?php

namespace App\Form\DataMapper;

use App\Entity\Choroba;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

final class mapChorobaNazwa implements DataMapperInterface
{
    /**
     * @param Choroba|null $data
     */
    public function mapDataToForms($data, $forms)
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $data) {
            return;
        }

        // invalid data type
        if (!$data instanceof Choroba) {
            throw new UnexpectedTypeException($data, Choroba::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms['nazwa']->setData($data->getNazwa());
        
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
        $data = new Choroba();
        $data->setNazwa($forms['nazwa']->getData()->getNazwa());
        /*
         $data = new Color(
            $forms['red']->getData(),
            $forms['green']->getData(),
            $forms['blue']->getData()
        );
         * */
        
    }
}