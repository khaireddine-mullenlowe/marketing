<?php


namespace MarketingBundle\Form;


use MarketingBundle\Entity\Invitation;
use MarketingBundle\Entity\MyaudiUserInvitation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyaudiUserInvitationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('myaudiUserId', IntegerType::class)
            ->add('invitation', EntityType::class, ['class' => Invitation::class]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => MyaudiUserInvitation::class,
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
