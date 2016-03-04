<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use MandarinMedien\MMCmfContentBundle\Form\FormTypeMetaReader;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;


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
        $className  = get_class($options['data']);

        $metaData = $em->getClassMetadata($className);
        $formTypeReader = new FormTypeMetaReader();

        // loop default fields
        foreach($metaData->getFieldNames() as $field)
        {
            if(in_array($field, array(
                'id'
            ))) continue;


            $builder->add($field, $formTypeReader->get($className, $field));

        }

        // loop association fields
        foreach($metaData->getAssociationNames() as $field)
        {

            if(in_array($field, array(
                'parent',
                'nodes',
                'routes'
            ))) continue;

            $builder->add($field, $formTypeReader->get($className, $field));
        }

        $builder->add('parent', $this->container->get('mm_cmf_admin.form_type.node_tree')->setParentNode($options['parent_node']));
    }


    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver
            ->setDefined(array('parent_node'))
            ->setAllowedTypes('parent_node', array(Node::class, 'null'))
            ->setDefault('parent_node', null);

    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_content_node';
    }

}