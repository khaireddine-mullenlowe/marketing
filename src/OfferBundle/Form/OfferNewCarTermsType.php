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
class OfferNewCarTermsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'monthNumber',
                IntegerType::class,
                ['required' => true]
            )
            ->add(
                'advancePayment',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'monthRentalNumber',
                IntegerType::class,
                ['required' => true]
            )
            ->add(
                'monthly',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'startDate',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'endDate',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'priceDate',
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
                'options',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'rangeName',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'mgpMin',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'mgpMax',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'co2EmissionMin',
                TextType::class,
                ['required' => true]
            )
            ->add(
                'co2EmissionMax',
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
