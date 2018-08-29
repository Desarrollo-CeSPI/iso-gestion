<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AclClasses
 */
class AclClasses
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $classType;


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
     * Set classType
     *
     * @param string $classType
     * @return AclClasses
     */
    public function setClassType($classType)
    {
        $this->classType = $classType;

        return $this;
    }

    /**
     * Get classType
     *
     * @return string 
     */
    public function getClassType()
    {
        return $this->classType;
    }
}
