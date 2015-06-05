<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', 'text', [
                'label' => 'form.lastname',
                'translation_domain' => 'user'
            ])
            ->add('firstname', 'text', [
                'label' => 'form.firstname',
                'translation_domain' => 'user'
            ])
            ->add('email', 'email', [
                'label' => 'form.email',
                'translation_domain' => 'user'
            ])
            ->add('password', 'repeated', [
                'type'            => 'password',
                'first_options'   => [
                    'label' => 'form.password',
                    'translation_domain' => 'user'
                ],
                'second_options'  => [
                    'label' => 'form.password_confirmation',
                    'translation_domain' => 'user'
                ],
                'invalid_message' => 'user.password.mismatch',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => ['Default', 'registration']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_user_register';
    }
}
