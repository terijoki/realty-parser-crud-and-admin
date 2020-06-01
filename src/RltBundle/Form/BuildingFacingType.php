<?php

namespace RltBundle\Form;

use RltBundle\Entity\Building;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingFacingType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['choices' => Building::FACING_TYPES]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}