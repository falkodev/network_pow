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
                'label' => 'registerform.lastname',
                'translation_domain' => 'user'
            ])
            ->add('firstname', 'text', [
                'label' => 'registerform.firstname',
                'translation_domain' => 'user'
            ])
            ->add('email', 'email', [
                'label' => 'registerform.email',
                'translation_domain' => 'user'
            ])
            ->add('password', 'repeated', [
                'type'            => 'password',
                'first_options'   => [
                    'label' => 'registerform.password',
                    'translation_domain' => 'user'
                ],
                'second_options'  => [
                    'label' => 'registerform.password_confirmation',
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
            'data_class' => 'AppBundle\Entity\User'
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
