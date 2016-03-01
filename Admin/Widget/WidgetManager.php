<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget;

class WidgetManager
{
    /**
     * @var WidgetInterface[]
     */
    protected $widgets;

    public function __construct()
    {
        $this->widgets = array();
    }

    public function addWidget(WidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    public function removeWidget(WidgetInterface $widget)
    {
        var_dump(array_keys($this->widgets, $widget));
    }

    public function getWidgets($region)
    {
        return array_filter($this->widgets, function($widget) use ($region) {
            return $widget->getRegion() == $region;
        });
    }
}