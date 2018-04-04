<?php

namespace OfferBundle\Form;

use OfferBundle\DataTransformer\DateToStringMonthTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

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
                [
                    'constraints' => [
                        new NotNull(),
                        new Regex('/[0-9]{2} [a-zA-Z]{1,10} [0-9]{4}/'),
                    ],
                ]
            )
            ->add(
                'modelName',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'engine',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'address',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            );

        $builder
            ->get('endDate')->addModelTransformer(
                new DateToStringMonthTransformer()
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
