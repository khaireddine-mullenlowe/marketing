<?php

namespace OfferBundle\Form;

use OfferBundle\DataTransformer\DateToStringMonthTransformer;
use OfferBundle\DataTransformer\ThousandSeparationTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

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
                [
                    'constraints' => [
                        new NotNull(['message' => 'monthNumber must not be empty']),
                        new Range(['min' => 1, 'max' => 500]),
                    ],
                ]
            )
            ->add(
                'advancePayment',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'advancePayment must not be empty']),
                    ],
                ]
            )
            ->add(
                'monthRentalNumber',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'monthRentalNumber must not be empty']),
                        new Range(['min' => 1, 'max' => 500]),
                    ],
                ]
            )
            ->add(
                'monthly',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'monthly must not be empty']),
                    ],
                ]
            )
            ->add(
                'startDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'startDate must not be empty']),
                        new Regex('/[0-9]{2} [a-zA-Z]{1,10} [0-9]{4}/'),
                    ],
                ]
            )
            ->add(
                'endDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'endDate must not be empty']),
                        new Regex('/[0-9]{2} [a-zA-Z]{1,10} [0-9]{4}/'),
                    ],
                ]
            )
            ->add(
                'priceDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'priceDate must not be empty']),
                        new Regex('/[0-9]{2} [a-zA-Z]{1,10} [0-9]{4}/'),
                    ],
                ]
            )
            ->add(
                'modelName',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'modelName must not be empty']),
                    ],
                ]
            )
            ->add(
                'engine',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'engine must not be empty']),
                    ],
                ]
            )
            ->add(
                'options',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'options must not be empty']),
                    ],
                ]
            )
            ->add(
                'rangeName',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'rangeName must not be empty']),
                    ],
                ]
            )
            ->add(
                'mgpMin',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'mgpMin must not be empty']),
                    ],
                ]
            )
            ->add(
                'mgpMax',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'mgpMax must not be empty']),
                    ],
                ]
            )
            ->add(
                'co2EmissionMin',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'co2EmissionMin must not be empty']),
                    ],
                ]
            )
            ->add(
                'co2EmissionMax',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'co2EmissionMax must not be empty']),
                    ],
                ]
            )
            ->add(
                'maximumKm',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'maximumKm must not be empty']),
                    ],
                ]
            )
            ->add(
                'partner',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(['message' => 'partner must not be empty']),
                    ],
                ]
            );

        $builder
            ->get('endDate')->addModelTransformer(
                new DateToStringMonthTransformer()
            );
        $builder
            ->get('startDate')->addModelTransformer(
                new DateToStringMonthTransformer()
            );
        $builder
            ->get('priceDate')->addModelTransformer(
                new DateToStringMonthTransformer()
            );
        $builder
            ->get('advancePayment')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('monthly')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('mgpMin')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('mgpMax')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('co2EmissionMin')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('co2EmissionMax')->addModelTransformer(
                new ThousandSeparationTransformer()
            );
        $builder
            ->get('maximumKm')->addModelTransformer(
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
        ]);
    }
}
