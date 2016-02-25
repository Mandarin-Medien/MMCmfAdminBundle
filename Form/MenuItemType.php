<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use MandarinMedien\MMCmfAdminBundle\Form\Types\EntityHiddenType;
use MandarinMedien\MMCmfAdminBundle\Form\Types\MenuListType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('position', 'hidden', array(
                'attr' => array(
                    'class' =>'position-field'
                )
            ))
            ->add('name')
            ->add('parent', 'entity_hidden', array(
                'class' => 'MandarinMedien\MMCmfMenuBundle\Entity\Menu',
                'attr' => array(
                    'class' => 'parent-field',
                )
            ))
            #->add('title')
            ->add('nodeRoute')
            ->add('items', MenuListType::class, array(
                'prototype' => false,
                'is_sublist' => true
            ))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MandarinMedien\MMCmfMenuBundle\Entity\MenuItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_menu_item';
    }
}