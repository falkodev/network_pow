<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilFormType extends RegisterFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->get('password')->setRequired(false);

        $builder->add('address', 'text', [
            'label'              => 'form.address',
            'translation_domain' => 'user',
            'required'           => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('validation_groups', ['Default']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_user_profil';
    }
}
