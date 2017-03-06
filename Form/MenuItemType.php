<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use MandarinMedien\MMCmfAdminBundle\Form\Types\MenuListType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('position', HiddenType::class, array(
                'attr' => array(
                    'class' =>'position-field'
                )
            ))
            ->add('name')
            /*->add('parent', 'entity_hidden', array(
                'class' => 'MandarinMedien\MMCmfMenuBundle\Entity\Menu',
                'attr' => array(
                    'class' => 'parent-field',
                )
            ))*/
            #->add('title')
            ->add('nodeRoute')
            ->add('items', MenuListType::class, array(
                'prototype' => false,
                'is_sublist' => true
            ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MandarinMedien\MMCmfMenuBundle\Entity\MenuItem'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_menu_item';
    }
}