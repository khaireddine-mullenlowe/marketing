<?php

namespace OfferBundle\Form;

use OfferBundle\Entity\OfferSale as Sale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class OfferSaleType
 * @package OfferBundle\Form
 */
class OfferSaleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partner', IntegerType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('visual', TextType::class)
            ->add('xPosition', IntegerType::class)
            ->add('yPosition', IntegerType::class)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('terms', TextType::class)
            ->add('agreements', IntegerType::class)
            ->add('model', IntegerType::class)
            ->add('monthly', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Sale::class,
            'allow_extra_fields' => true,
            'csrf_protection'    => false,
        ]);
    }
}
