<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use MandarinMedien\MMCmfAdminBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('image')
            ->add('firstname')
            ->add('name')
            ->add('email')
            ->add('roles', ChoiceType::class, array(
                'choices' => array(
                    'Benutzer'=>'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN'
                ),
                'multiple' => true
            ))
            ->add('plain_password', PasswordType::class, array(
                'label' => 'Password',
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_user';
    }
}
