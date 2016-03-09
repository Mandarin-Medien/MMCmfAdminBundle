<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget\Type;

use MandarinMedien\MMCmfAdminBundle\Admin\Widget\WidgetInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HTTPFoundation\Request;

class LinkWidget extends BaseWidget
{

    protected $value;
    protected $action;
    protected $icon;
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
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
     * @param mixed $title
     * @return LinkWidget
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return LinkWidget
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function isActive()
    {
        return $this->getRequest()->attributes->get('_route') == $this->action;
    }


    public function getRequest()
    {
        return $this->request;
    }


    public function getName()
    {
        return 'mm_cmf_admin_link_widget';
    }


}