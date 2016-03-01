<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type;

use MandarinMedien\MMCmfAdminBundle\Admin\Widget\WidgetInterface;

class BaseWidget implements WidgetInterface
{

    protected $name;
    protected $icon;
    protected $region;

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * {@inheritdoc}
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRegion($region)
    {
       $this->region = $region;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cmf_admin_base_widget';
    }
}