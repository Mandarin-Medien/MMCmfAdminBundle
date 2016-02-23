<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin;

class AdminMenu
{
    protected $widgets;

    public function __construct()
    {
        $this->widgets = array();
    }


    public function addWidget(Widget $widget)
    {
        $this->widgets[] = $widget;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }
}