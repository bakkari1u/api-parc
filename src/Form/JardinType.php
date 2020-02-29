<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class JardinType
 * @package App\Form
 */
class JardinType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactInformation',ContactInformationType::class)
            ->add('usefulInformation',UsefulInformationType::class)
            ->add('openingConditions',OpeningConditionsType::class)
            ->add('visit',VisitType::class)
            ->add('information',InformationType::class)
            ->add('special',SpecialType::class)
            ->add('media',MediaType::class)

        ;
    }
}