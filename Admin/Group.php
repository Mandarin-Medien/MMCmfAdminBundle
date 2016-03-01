<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin;

class Group
{

    protected $name;
    protected $icon;


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
}