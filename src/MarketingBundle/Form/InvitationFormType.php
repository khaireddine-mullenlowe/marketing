<?php


namespace MarketingBundle\Form;


use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\Invitation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class InvitationFormType
 * @package MarketingBundle\Form
 */
class InvitationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campaignEvent', EntityType::class, ['class' => CampaignEvent::class])
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('teaser', TextType::class)
            ->add('mailto', TextType::class)
            ->add('pathVisual', TextType::class)
            ->add('status', IntegerType::class)
            ;
    }

    /**
     * {@inheritdoc}gst
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => Invitation::class,
            'allow_extra_fields' => true,
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
