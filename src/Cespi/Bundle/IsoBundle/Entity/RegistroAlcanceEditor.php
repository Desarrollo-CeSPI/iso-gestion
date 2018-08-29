<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroAlcance
 */
class RegistroAlcanceEditor
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
     * @var \Cespi\Bundle\IsoBundle\Entity\Registro
     */
    private $idRegistro;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Alcances
     */
    private $idAlcance;


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
     * @return RegistroAlcance
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
     * Set idRegistro
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Registro $idRegistro
     * @return RegistroAlcance
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

    /**
     * Set idAlcance
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Alcances $idAlcance
     * @return RegistroAlcance
     */
    public function setIdAlcance(\Cespi\Bundle\IsoBundle\Entity\Alcances $idAlcance = null)
    {
        $this->idAlcance = $idAlcance;

        return $this;
    }

    /**
     * Get idAlcance
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Alcances 
     */
    public function getIdAlcance()
    {
        return $this->idAlcance;
    }
}
