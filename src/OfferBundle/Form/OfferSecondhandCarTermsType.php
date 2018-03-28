<?php

namespace OfferBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OfferAftersaleTermsType
 * @package OfferBundle\Form
 */
class OfferSecondhandCarTermsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'endDate',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'modelName',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'engine',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'email',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'address',
                TextType::class,
                ['required' => true]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'    => false,
        ]);
    }
}
