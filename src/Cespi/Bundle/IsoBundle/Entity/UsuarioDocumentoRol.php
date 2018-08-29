<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioDocumentoRol
 */
class UsuarioDocumentoRol
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Documento
     */
    private $idDocumento;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Usuarios
     */
    private $idUsuario;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\Rol
     */
    private $idRol;


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
     * Set idDocumento
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Documento $idDocumento
     * @return UsuarioDocumentoRol
     */
    public function setIdDocumento(\Cespi\Bundle\IsoBundle\Entity\Documento $idDocumento = null)
    {
        $this->idDocumento = $idDocumento;

        return $this;
    }

    /**
     * Get idDocumento
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Documento 
     */
    public function getIdDocumento()
    {
        return $this->idDocumento;
    }

    /**
     * Set idUsuario
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Usuarios $idUsuario
     * @return UsuarioDocumentoRol
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
     * Set idRol
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Rol $idRol
     * @return UsuarioDocumentoRol
     */
    public function setIdRol(\Cespi\Bundle\IsoBundle\Entity\Rol $idRol = null)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\Rol 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }
}
