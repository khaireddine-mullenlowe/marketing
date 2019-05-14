<?php

namespace MarketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CampaignEventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['constraints' => [new Required(), new NotNull()]])
            ->add('description', TextType::class)
            ->add('descriptionEvent', TextType::class)
            ->add('descriptionTarget', TextType::class)
            ->add('waitingList', ChoiceType::class, ['choices' => [true, false]])
            ->add('startDate', DateType::class, [
                'constraints' => [new Date()],
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
            ])
            ->add('endDate', DateType::class, [
                'constraints' => [new Date()],
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
             ])
            ->add('status', IntegerType::class, [
                'constraints' => [
                    new Required(),
                    new NotNull(),
                    new Range(['min' => 0, 'max' => 1])
                ]
            ])
            ->add('legacyId', IntegerType::class, ['constraints' => [new Range(['min' => 1, 'max' => null])]])
            ->add('eventType', EntityType::class, ['class' => \MarketingBundle\Entity\EventType::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketingBundle\Entity\CampaignEvent',
            'csrf_protection' => false,
            'allow_extra_fields' => false,
            'extra_fields_message' => 'This form should not contain extra fields : "{{ extra_fields }}".',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
