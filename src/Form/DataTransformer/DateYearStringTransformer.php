<?php

namespace App\Form\DataTransformer;

use App\Entity\Schemat;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateYearStringTransformer implements DataTransformerInterface
{
    //private $entityManager;

    public function __construct()//EntityManagerInterface $entityManager
    {
        //$this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  \Date|null $issue
     * @return string
     */
    public function transform($date)
    {
        if (null === $date) {
            return '';
        }

        return $date->format('Y');
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $year
     * @return \Date|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($year)
    {
        // no issue number? It's optional, so that's ok
        if (!$year) {
            return;
        }

        //$year = $forms['startYear']->getData();
        $newYear = new \DateTime("$year-01-01");

        if (null === $newYear) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'próba użycia roku "%s"!',
               $year
            ));
        }

        return $newYear;
    }
}