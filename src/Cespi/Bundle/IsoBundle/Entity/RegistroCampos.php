<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroCampos
 */
class RegistroCampos
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
    private $idTipoCampo;

    /**
     * @var integer
     */
    private $orden;
    
     /**
     * @var string
     */
    private $nombre;


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
     * @return RegistroCampos
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
     * Set idTipoCampo
     *
     * @param integer $idTipoCampo
     * @return RegistroCampos
     */
    
    
    /*public function setidTipoCampo($idTipoCampo)
    {
        $this->idTipoCampo = $idTipoCampo;

        return $this;
    }*/
	
    /**
     * Get idTipoCampo
     *
     * @return integer 
     */
    /*
    public function getidTipoCampo()
    {
        return $this->idTipoCampo;
    }
	*/
    /**
     * Set orden
     *
     * @param integer $orden
     * @return RegistroCampos
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }
    
    /**
     * Set orden
     *
     * @param integer $campo
     * @return RegistroCampos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get orden
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
        /**
     * Get orden
     *
     * @return string 
     */
    public function getNombreWidget()
    {
        return  str_replace(' ', '_', strtolower($this->nombre));
    }
    
   

    /**
     * Set idTipoCampo
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\TipoCampo $idTipoCampo
     * @return RegistroCampos
     */
    public function setIdTipoCampo(\Cespi\Bundle\IsoBundle\Entity\TipoCampo $idTipoCampo = null)
    {
        $this->idTipoCampo = $idTipoCampo;

        return $this;
    }

    /**
     * Get idTipoCampo
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\TipoCampo 
     */
    public function getIdTipoCampo()
    {
        return $this->idTipoCampo;
    }
}
