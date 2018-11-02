<?php

namespace RltBundle\Validator;

use RltBundle\Entity\Metro;
use Symfony\Component\Validator\Constraint;

/**
 * Constraint matches received value
 * with metro list and build violation
 * when does not find a match.
 */
class MetroConstraint extends Constraint
{
    public $message = 'Given value %value% not found in metro list';

    /**
     * @var Metro[]
     */
    public $metroList;

    /**
     * @return Metro[]
     */
    public function getMetroList(): array
    {
        return $this->metroList;
    }

    /**
     * @param Metro[] $metroList
     *
     * @return MetroConstraint
     */
    public function setMetroList(array $metroList): MetroConstraint
    {
        $this->metroList = $metroList;

        return $this;
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return MetroValidator::class;
    }
}
