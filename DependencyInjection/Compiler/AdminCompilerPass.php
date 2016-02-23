<?php

namespace MandarinMedien\MMCmfAdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AdminCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('mm_cmf_admin.admin_sidebar')) {
            return;
        }

        $definition = $container->findDefinition(
            'mm_cmf_admin.admin_sidebar'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'mm_cmf_admin.admin_menu'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addWidget',
                array(new Reference($id))
            );
        }
    }
}