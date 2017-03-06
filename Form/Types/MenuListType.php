<?php

namespace MandarinMedien\MMCmfAdminBundle\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use MandarinMedien\MMCmfAdminBundle\Form\MenuItemType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuListType extends AbstractType
{
    public function buildView(FormView $view, FormInterface$form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['is_sublist'] = $options['is_sublist'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('entry_type', MenuItemType::class)
            ->setDefault('allow_add', true)
            ->setDefault('allow_delete', true)
            ->setDefault('by_reference', false)
            ->setDefault('prototype', true);

        $resolver
            ->setDefined(array('is_sublist'))
            ->setAllowedTypes('is_sublist', 'boolean')
            ->setDefault('is_sublist', false);

    }


    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_menu_list_type';
    }


    public function getParent()
    {
        return CollectionType::class;
    }
}