<?php

namespace MandarinMedien\MMCmfAdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AdminCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('mm_cmf_admin.widget_manager')) {
            return;
        }

        $definition = $container->findDefinition(
            'mm_cmf_admin.widget_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'mm_cmf_admin.admin_widget'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addWidget',
                array(new Reference($id))
            );

            $definition2 = $container->findDefinition($id);
            $taggedServices2 = $container->findTaggedServiceIds($id);
            foreach ($taggedServices2 as $id2 => $tags2) {
                $definition2->addMethodCall(
                    'addLinkWidget',
                    array(new Reference($id2))
                );
            }
        }
    }
}