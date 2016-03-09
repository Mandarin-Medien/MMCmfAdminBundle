<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type;

use Symfony\Component\HttpFoundation\Request;

class LinkGroupWidget extends BaseWidget
{

    /**
     * @var LinkWidget[]
     */
    protected $linkWidgets;

    /**
     * @var string string represantaion of font-awesome ivcon
     */
    protected $icon;

    /**
     * @var string name of the group
     */
    protected $value;


    /**
     * LinkGroupWidget constructor.
     */
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


    /**
     * check if group has an active widget
     *
     * @return bool
     */
    public function isActive()
    {
        foreach ($this->getLinkWidgets() as $widget) {
            if($widget->isActive()) return true;
        }

        return false;
    }


    /**
     * add LinkWidget to Group
     * @param LinkWidget $widget
     */
    public function addLinkWidget(LinkWidget $widget)
    {
        $this->linkWidgets[] = $widget;
    }

    /**
     * @return LinkWidget[]
     */
    public function getLinkWidgets()
    {
        return $this->linkWidgets;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "cmf_admin_link_group_widget";
    }
}