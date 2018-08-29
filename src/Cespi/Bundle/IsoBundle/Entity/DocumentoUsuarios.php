<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoUsuarios
 */
class DocumentoUsuarios
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idDocumento;

    /**
     * @var integer
     */
    private $idUsuario;

    /**
     * @var integer
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
     * @param integer $idDocumento
     * @return DocumentoUsuarios
     */
    public function setIdDocumento($idDocumento)
    {
        $this->idDocumento = $idDocumento;

        return $this;
    }

    /**
     * Get idDocumento
     *
     * @return integer 
     */
    public function getIdDocumento()
    {
        return $this->idDocumento;
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     * @return DocumentoUsuarios
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return integer 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set idRol
     *
     * @param integer $idRol
     * @return DocumentoUsuarios
     */
    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return integer 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }
}
