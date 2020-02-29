<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UsefulInformationType
 * @package App\Form
 */
class UsefulInformationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('area',TextType::class)
            ->add('disabilityAccessibility',TextType::class)
            ->add('state',TextType::class)
            ->add('remarkableLabel',ChoiceType::class,[
                'choices' => array(
                    true => true,
                    false => false,

                ),
            ])

        ;
    }

}