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
                        new NotNull(),
                        new Range(['min' => 1, 'max' => 100000]),
                    ],
                ]
            )
            ->add(
                'advancePayment',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'monthRentalNumber',
                IntegerType::class
            )
            ->add(
                'monthly',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'startDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                        new Regex('/[0-9]{2} [a-zA-Z]{1,10} [0-9]{4}/'),
                    ],
                ]
            )
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
                'priceDate',
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
                'options',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'rangeName',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'mgpMin',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'mgpMax',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'co2EmissionMin',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'co2EmissionMax',
                MoneyType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'maximumKm',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'partner',
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
