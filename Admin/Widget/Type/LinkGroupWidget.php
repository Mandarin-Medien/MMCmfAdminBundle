<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type;

class LinkGroupWidget extends BaseWidget
{

    protected $linkWidgets;
    protected $icon;
    protected $value;

    public function __construct()
    {
        $linKWidgets = array();
    }

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
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return LinkGroupWidget
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }


    public function addLinkWidget(LinkWidget $widget)
    {
        $this->linkWidgets[] = $widget;
    }

    public function getLinkWidgets()
    {
        return $this->linkWidgets;
    }

    public function getName()
    {
        return "cmf_admin_link_group_widget";
    }
}