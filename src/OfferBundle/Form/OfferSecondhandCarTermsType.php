<?php

namespace OfferBundle\Form;

use OfferBundle\Entity\OfferSecondhandCarTermsProperty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OfferSecondhandTermsType
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
            ->add('modelName', TextType::class)
            ->add('engine', TextType::class)
            ->add('email', TextType::class)
            ->add('address', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => OfferSecondhandCarTermsProperty::class,
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);
    }
}
