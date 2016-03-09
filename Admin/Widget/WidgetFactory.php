<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget;


use MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type\LinkWidget;
use MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type\LinkGroupWidget;
use Symfony\Component\DependencyInjection\Container;


class WidgetFactory
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function createWidget($value, $action, $icon, LinkGroupWidget $group = null)
    {
        $linkWidget = (new LinkWidget($this->container))
            ->setValue($value)
            ->setAction($action)
            ->setIcon($icon)
            ->setRegion('sidebar')
        ;

        if($group) {
            $group->addLinkWidget($linkWidget);
        }

        return $linkWidget;
    }

    public function createGroupWidget($value, $icon)
    {
        return ((new LinkGroupWidget())
            ->setValue($value)
            ->setIcon($icon)
            ->setRegion('sidebar')
        );
    }

}