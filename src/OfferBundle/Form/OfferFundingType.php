<?php

namespace OfferBundle\Form;

use OfferBundle\Entity\OfferFunding;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OfferFundingType
 * @package OfferBundle\Form
 */
class OfferFundingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class)
            ->add('name', TextType::class)
            ->add('modelId', TextType::class)
            ->add('rangeId', TextType::class)
            ->add('price', TextType::class)
            ->add('withContribution', IntegerType::class)
            ->add('guaranteed', IntegerType::class)
            ->add('maintained', IntegerType::class)
            ->add('details', TextareaType::class)
            ->add('legalNotice', TextareaType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('visual', TextareaType::class)
            ->add('status', IntegerType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => OfferFunding::class,
            'allow_extra_fields' => true,
            'csrf_protection'    => false,
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
