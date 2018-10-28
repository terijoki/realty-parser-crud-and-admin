<?php

namespace RltBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class MetroConstraint.
 */
class MetroValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     * @param mixed      $metro
     */
    public function validate($metro, Constraint $constraint)
    {
        foreach ($constraint->metroList as $list) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%value%', $metro)
                ->addViolation()
            ;
        }
    }
}
