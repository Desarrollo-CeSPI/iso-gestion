<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroCargadoDato
 */
class RegistroCargadoDato
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $dato;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\RegistroCampos
     */
    private $idRegistroCampo;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\RegistroCargado
     */
    private $idRegistroCargado;
    
    /**
     * @var integer
     */
    private $user;    

   /**
     * @var boolean
     */
    private $control_envio_email;
    
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
     * Set dato
     *
     * @param string $dato
     * @return RegistroCargadoDato
     */
    public function setDato($dato)
    {
        $this->dato = $dato;

        return $this;
    }

    /**
     * Get dato
     *
     * @return string 
     */
    public function getDato()
    {
        return $this->dato;
    }

    public function setUser($dato)
    {
        $this->user = $dato;

        return $this;
    }

    /**
     * Get dato
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
     * @return RegistroCargadoDato
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
     * Set idRegistroCampo
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\RegistroCampos $idRegistroCampo
     * @return RegistroCargadoDato
     */
    public function setIdRegistroCampo(\Cespi\Bundle\IsoBundle\Entity\RegistroCampos $idRegistroCampo = null)
    {
        $this->idRegistroCampo = $idRegistroCampo;

        return $this;
    }

    /**
     * Get idRegistroCampo
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\RegistroCampos 
     */
    public function getIdRegistroCampo()
    {
        return $this->idRegistroCampo;
    }

    /**
     * Set idRegistroCargado
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\RegistroCargado $idRegistroCargado
     * @return RegistroCargadoDato
     */
    public function setIdRegistroCargado(\Cespi\Bundle\IsoBundle\Entity\RegistroCargado $idRegistroCargado = null)
    {
        $this->idRegistroCargado = $idRegistroCargado;

        return $this;
    }

    /**
     * Get idRegistroCargado
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\RegistroCargado 
     */
    public function getIdRegistroCargado()
    {
        return $this->idRegistroCargado;
    }
    
    /**
     * Get getControlEnvioEmail
     *
     * @return boolean
     */
    public function getControlEnvioEmail()
    {
        return $this->control_envio_email;
    }
    /**
     * Set getControlEnvioEmail
     *
     * @return RegistroCampos
     */
    public function setControlEnvioEmail($boolean)
    {
        $this->control_envio_email = $boolean;
        return $this;
    }
}
