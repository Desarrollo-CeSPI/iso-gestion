<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroCargado
 */
class RegistroCargado
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var integer
     */
    private $user;    

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Registro
     */
    private $idRegistro;


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
     * Set user
     *
     * @return string 
     */
     
    public function setUser($dato)
    {
        $this->user = $dato;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return RegistroCargado
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set idRegistro
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Registro $idRegistro
     * @return RegistroCargado
     */
    public function setIdRegistro(\Cespi\Bundle\IsoBundle\Entity\Registro $idRegistro = null)
    {
        $this->idRegistro = $idRegistro;

        return $this;
    }

    /**
     * Get idRegistro
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Registro 
     */
    public function getIdRegistro()
    {
        return $this->idRegistro;
    }
}
