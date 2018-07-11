<?php

namespace MarketingBundle\Form;

use MarketingBundle\Entity\MarketingObjective;
use MarketingBundle\Entity\MyaudiUserMarketingObjective;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MyaudiUserMarketingObjectiveType
 * @package MarketingBundle\Form
 */
class MyaudiUserMarketingObjectiveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'myaudiUserId',
                IntegerType::class
            )
            ->add(
                'marketingObjective',
                EntityType::class,
                ['class' => MarketingObjective::class]
            )
            ->add(
                'isUnsubscribe',
                CheckboxType::class
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => MyaudiUserMarketingObjective::class,
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
