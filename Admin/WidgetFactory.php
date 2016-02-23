<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin;


class WidgetFactory {

    public function createWidget($name, $action, $icon)
    {
        return ((new Widget())
            ->setName($name)
            ->setAction($action)
            ->setIcon($icon)
        );
    }

}