<?php

namespace RltBundle\Form;

use RltBundle\Entity\Bank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelatedEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', EntityType::class, [
            'class' => Bank::class,
            'choice_label' => 'name',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}