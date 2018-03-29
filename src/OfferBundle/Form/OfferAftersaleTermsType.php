<?php

namespace OfferBundle\Form;

use DateTime;
use OfferBundle\DataTransformer\DateToStringMonthTransformer;
use OfferBundle\DataTransformer\ThousandSeparationTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OfferAftersaleTermsType
 * @package OfferBundle\Form
 */
class OfferAftersaleTermsType extends AbstractType
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
                'km',
                IntegerType::class,
                ['required' => false]
            );

        $builder
            ->get('endDate')->addModelTransformer(
                new DateToStringMonthTransformer()
            );

        $builder
            ->get('km')
            ->addModelTransformer(
                new ThousandSeparationTransformer()
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);
    }
}
