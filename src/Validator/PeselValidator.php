<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PeselValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Pesel */

          
        
        if (!$constraint instanceof Pesel) {
            throw new UnexpectedTypeException($constraint, Pesel::class);
        }
        
        /*
        if (!$constraint instanceof ContainsAlphanumeric) {
            throw new UnexpectedTypeException($constraint, ContainsAlphanumeric::class);
        }
         */

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        if (!preg_match('/^[0-9]{11}$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ wart }}', $value)
                ->addViolation();
        }
        if(strlen($value) == 11) {
            $arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3);
            $intSum = 0;
            for ($i = 0; $i < 10; $i++) {
                $intSum += $arrSteps[$i] * $value[$i];
            }
            $int = 10 - $intSum % 10;
            $intControlNr = ($int == 10)?0:$int;
            if ($intControlNr != $value[10]) //sprawdzamy czy taka sama suma kontrolna jest w ciągu
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ wart }}', $value)
                    ->addViolation();
            }
        }
        /*
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
         */ 
    }
}
