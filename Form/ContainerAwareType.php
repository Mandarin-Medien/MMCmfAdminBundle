<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContainerAwareType extends AbstractType implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'container' => $this->container
        ));
    }

    public function getName() {
        return 'container_aware_type';
    }

    public function getParent() {
        return 'form';
    }
}