<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuariosAlcance
 */
class UsuariosAlcance
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Usuarios
     */
    private $idUsuario;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Alcances
     */
    private $idAlance;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return UsuariosAlcance
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set idUsuario
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Usuarios $idUsuario
     * @return UsuariosAlcance
     */
    public function setIdUsuario(\Cespi\Bundle\IsoBundle\Entity\Usuarios $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Usuarios 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set idAlance
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Alcances $idAlance
     * @return UsuariosAlcance
     */
    public function setIdAlance(\Cespi\Bundle\IsoBundle\Entity\Alcances $idAlance = null)
    {
        $this->idAlance = $idAlance;

        return $this;
    }

    /**
     * Get idAlance
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Alcances 
     */
    public function getIdAlance()
    {
        return $this->idAlance;
    }
}
