<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use MandarinMedien\MMCmfRoutingBundle\Entity\ExternalNodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Entity\RedirectNodeRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolver;

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


        if (get_class($options['data']) != ExternalNodeRoute::class) {
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
        }


        $builder
            ->add('submit', SubmitType::class, array('label' => 'save'))
            ->add('save_and_add', SubmitType::class, array(
                'attr' => array(
                    'data-target' => $container->get('router')->generate('mm_cmf_admin_noderoute_new')
                ),
            ))
            ->add('save_and_back', SubmitType::class, array(
                'attr' => array(
                    'data-target' => $container->get('router')->generate('mm_cmf_admin_noderoute')
                )
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NodeRoute::class
        ));
    }


    public function getParent()
    {
        return ContainerAwareType::class;
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_noderoute';
    }
}
