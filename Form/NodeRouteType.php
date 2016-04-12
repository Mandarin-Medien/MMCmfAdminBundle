<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use MandarinMedien\MMCmfRoutingBundle\Entity\ExternalNodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Entity\RedirectNodeRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeRouteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $container = $options['container'];

        $builder
            ->add('route');

        if(get_class($options['data']) != ExternalNodeRoute::class) {
            $builder->add('node', null, array(
                'required' => true
            ));
        }

        if(get_class($options['data']) == RedirectNodeRoute::class) {
            $builder->add('statusCode', ChoiceType::class, array(
                'required' => true,
                'choices' => array(
                    '301' => 301,
                    '302' => 302
                )
            ));
        }

        $builder
            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $container->get('router')->generate('mm_cmf_admin_noderoute_new')
                ),
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $container->get('router')->generate('mm_cmf_admin_noderoute')
                )
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute'
        ));
    }


    public function getParent()
    {
        return 'container_aware_type';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_noderoute';
    }
}
