<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin\Widget;

interface WidgetInterface
{

    /**
     * @return string name of the widget
     */
    public function getName();


    /**
     * @param string region
     * @return set the area wherew the widget will be rendered
     */
    public function setRegion($regions);


    /**
     * get the name of the region
     * @return string
     */
    public function getRegion();

}