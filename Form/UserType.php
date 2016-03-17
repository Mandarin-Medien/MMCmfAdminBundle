<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                    'ROLE_USER' => 'Benutzer',
                    'ROLE_ADMIN' => 'Admin'
                ),
                'multiple' => true
            ))
            ->add('plain_password', 'password', array(
                'label' => 'Password',
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MandarinMedien\MMCmfAdminBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_user';
    }
}
