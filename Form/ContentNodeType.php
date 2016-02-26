<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentNodeType extends AbstractType
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->container->get('doctrine')->getManager();

        $metaData = $em->getClassMetadata(get_class($options['data']));


        foreach($metaData->getFieldNames() as $field)
        {
            if(in_array($field, array(
                'id'
            ))) continue;

            $builder->add($field);
        }

        foreach($metaData->getAssociationNames() as $field)
        {

            if(in_array($field, array(
                'nodes',
                'routes'
            ))) continue;

            $builder->add($field);
        }
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_content_node';
    }

}