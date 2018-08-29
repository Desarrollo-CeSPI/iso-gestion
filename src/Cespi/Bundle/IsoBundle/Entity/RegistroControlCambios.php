<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroControlCambios
 */
class RegistroControlCambios
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idRegistro;

    /**
     * @var integer
     */
    private $revision;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $motivo;

    /**
     * @var integer
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * @var string
     */
    protected $link;


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
     * Set idRegistro
     *
     * @param integer $idRegistro
     * @return RegistroControlCambios
     */
    public function setIdRegistro($idRegistro)
    {
        $this->idRegistro = $idRegistro;

        return $this;
    }

    /**
     * Get idRegistro
     *
     * @return integer 
     */
    public function getIdRegistro()
    {
        return $this->idRegistro;
    }

    /**
     * Set revision
     *
     * @param integer $revision
     * @return RegistroControlCambios
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return integer 
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set fecha
     *
     * @param integer $fecha
     * @return RegistroControlCambios
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return integer 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set motivo
     *
     * @param integer $motivo
     * @return RegistroControlCambios
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return integer 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return RegistroControlCambios
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return RegistroControlCambios
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    
     /**
     * Set link
     *
     * @param string link
     * @return RegistroControlCambios
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }
    
    
    
}
