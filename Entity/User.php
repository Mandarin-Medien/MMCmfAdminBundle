<?php

namespace MandarinMedien\MMCmfAdminBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use MandarinMedien\MMMediaBundle\Entity\Media;
use MandarinMedien\MMMediaBundle\Entity\MediaSortable;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $name;


    /**
     * @var MediaSortable
     */
    protected $image;

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MediaSortable
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param MediaSortable $image
     * @return User
     */
    public function setImage(MediaSortable $image)
    {
        $this->image = $image;
        return $this;
    }


}

