<?php

namespace MandarinMedien\MMCmfAdminBundle\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use MandarinMedien\MMCmfAdminBundle\Form\MenuItemType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuListType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver); // TODO: Change the autogenerated stub

        $resolver->setDefault('entry_type', MenuItemType::class);
    }


    public function getName()
    {
        return 'mm_cmf_admin_menu_list_type';
    }


    public function getParent()
    {
        return CollectionType::class;
    }
}