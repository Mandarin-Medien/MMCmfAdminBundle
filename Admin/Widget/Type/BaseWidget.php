<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type;

use MandarinMedien\MMCmfAdminBundle\Admin\Widget\WidgetInterface;

class BaseWidget implements WidgetInterface
{

    protected $region;

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