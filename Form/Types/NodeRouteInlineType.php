<?php

namespace MandarinMedien\MMCmfAdminBundle\Form\Types;

use MandarinMedien\MMCmfRoutingBundle\Entity\ExternalNodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Entity\RedirectNodeRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeRouteInlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*if (get_class($options['data']) != ExternalNodeRoute::class) {
            $builder->add('node', null, array(
                'required' => true
            ));
        }

        if (get_class($options['data']) == RedirectNodeRoute::class) {
            $builder->add('statusCode', ChoiceType::class, array(
                'required' => true,
                'choices' => array(
                    '301' => 301,
                    '302' => 302
                )
            ));
        }*/

        $builder->add('route');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_noderoute_inline';
    }
}