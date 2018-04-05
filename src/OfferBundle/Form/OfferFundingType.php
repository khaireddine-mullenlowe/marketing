<?php

namespace OfferBundle\Form;


use OfferBundle\Entity\OfferFunding;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferFundingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class)
            ->add('label', TextType::class)
            ->add('modelId', TextType::class)
            ->add('rangeId', TextType::class)
            ->add('price', TextType::class)
            ->add('withContribution', ChoiceType::class, ['choices' => [true, false]])
            ->add('guaranteed', ChoiceType::class, ['choices' => [true, false]])
            ->add('maintained', ChoiceType::class, ['choices' => [true, false]])
            ->add('details', TextareaType::class)
            ->add('legalNotice', TextareaType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('visual', TextareaType::class)
            ->add('active', ChoiceType::class, ['choices' => [true, false]]);
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
}