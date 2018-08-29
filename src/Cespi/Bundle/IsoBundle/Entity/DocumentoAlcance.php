<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoAlcance
 */
class DocumentoAlcance
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
     * @var \Cespi\Bundle\IsoBundle\Entity\Documento
     */
    private $documento;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Alcances
     */
    private $alcance;


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
     * @return DocumentoAlcance
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
     * Set documento
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Documento $documento
     * @return DocumentoAlcance
     */
    public function setDocumento(\Cespi\Bundle\IsoBundle\Entity\Documento $documento = null)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Documento 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set alcance
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Alcances $alcance
     * @return DocumentoAlcance
     */
    public function setAlcance(\Cespi\Bundle\IsoBundle\Entity\Alcances $alcance = null)
    {
        $this->alcance = $alcance;

        return $this;
    }

    /**
     * Get alcance
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Alcances 
     */
    public function getAlcance()
    {
        return $this->alcance;
    }
}
