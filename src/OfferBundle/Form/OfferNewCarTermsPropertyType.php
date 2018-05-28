<?php

namespace OfferBundle\Form;

use OfferBundle\Entity\OfferNewCarTermsProperty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OfferNewCarTermsPropertyType
 * @package OfferBundle\Form
 */
class OfferNewCarTermsPropertyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monthNumber', IntegerType::class)
            ->add('advancePayment', MoneyType::class)
            ->add('priceDate', TextType::class)
            ->add('modelName', TextType::class)
            ->add('engine', TextType::class)
            ->add('options', TextType::class)
            ->add('rangeName', TextType::class)
            ->add('mgpMin', MoneyType::class)
            ->add('mgpMax', MoneyType::class)
            ->add('co2EmissionMin', MoneyType::class)
            ->add('co2EmissionMax', MoneyType::class)
            ->add('maximumKm', IntegerType::class)
            ->add('partnerName', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => OfferNewCarTermsProperty::class,
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
