<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin;

class Widget
{

    protected $name;
    protected $action;
    protected $icon;
    protected $group;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Widget
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return Widget
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }


    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     * @return Widget
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
        return $this;
    }
}