<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class ContactInformationType
 * @package App\Form
 */
class ContactInformationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameParcGarden',TextType::class)
            ->add('address',TextType::class)
            ->add('zipCode',TextType::class)
            ->add('city',TextType::class)
            ->add('nameOwner',TextType::class)
            ->add('phone',TextType::class)
            ->add('emailAdress',TextType::class)
            ->add('fax',TextType::class)
        ;
    }

}