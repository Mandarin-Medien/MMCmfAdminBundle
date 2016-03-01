<?php

namespace MandarinMedien\MMCmfAdminBundle\Admin;


class GroupFactory {

    public function createGroup($name, $icon)
    {
        return ((new Group())
            ->setName($name)
            ->setIcon($icon)
        );
    }

}