<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget;


use MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type\BaseWidget;
use MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type\LinkWidget;
use MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type\LinkGroupWidget;

class WidgetFactory {

    public function createWidget($value, $action, $icon, LinkGroupWidget $group = null)
    {
        $linkWidget = ((new LinkWidget())
            ->setValue($value)
            ->setAction($action)
            ->setIcon($icon)
            ->setRegion('sidebar')
        );

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