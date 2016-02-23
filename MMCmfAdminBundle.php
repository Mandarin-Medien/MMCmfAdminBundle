<?php

namespace MandarinMedien\MMCmfAdminBundle;

use MandarinMedien\MMCmfAdminBundle\DependencyInjection\Compiler\AdminCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MMCmfAdminBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminCompilerPass());
    }

}
