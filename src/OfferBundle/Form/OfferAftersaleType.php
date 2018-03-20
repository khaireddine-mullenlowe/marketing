<?php

namespace OfferBundle\Form;

use OfferBundle\Entity\OfferAftersale as Aftersale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferAftersaleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partner', IntegerType::class)
            ->add('details', TextType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('visual', TextType::class)
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class)
            ->add('description', TextType::class)
            ->add('terms', TextType::class)
            ->add('agreements', IntegerType::class)
            ->add('discount1', TextType::class)
            ->add('discount2', TextType::class)
            ->add('discount3', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Aftersale::class,
            'allow_extra_fields' => true,
            'csrf_protection'    => false
        ]);
    }
}