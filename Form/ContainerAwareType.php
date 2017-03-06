<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContainerAwareType extends AbstractType implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'container' => $this->container
        ));
    }

    public function getBlockPrefix() {
        return 'container_aware_type';
    }

    public function getParent() {
        return FormType::class;
    }
}