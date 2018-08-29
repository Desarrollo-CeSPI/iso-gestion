<?php
/*
ALTER TABLE  `registro` ADD  `fecha_ultima_actualizacion` TIMESTAMP NOT NULL ,
ADD  `revision_actual` INT NOT NULL DEFAULT  '0'
*/


namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cespi\Bundle\IsoBundle\Entity\TipoCampo;
/**
 * Registro
 */
class Registro
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;
    
    /**
     * @var \DateTime
     */
    private $fechaUltimaActualizacion;
    
    /**
     * @var integer
     */
    private $revisionActual;    
    
    /**
     * @var integer
     */        
    private $alcances;
    
    /**
     * @var integer
     */        
    private $alcancesEditor;    
    
    /**
     * @var string
     */
    private $descripcion;
     /**
     * @ORM\ManyToMany(targetEntity="tipoCampo")
     * @ORM\JoinTable(name="registro_campos",
     *      joinColumns={@ORM\JoinColumn(name="id_registro", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_campo", referencedColumnName="id")}
     *      )
     **/
    private $tipoCampo;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Registro
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    /**
     * Get tipoCampo
     *
     * @return string 
     */
    public function getTipoCampo()
    {
        return $this->tipoCampo;
    }
    
    
    public function __toString()
    {
        return $this->getNombre();
    }        
    
     /**
     * Set tipoCampo
     *
     * @param string $tipoCampo
     * @return Registro
     */
    public function setTipoCampo($campos)
    {
        $this->tipoCampo = $campos;

        return $this;
    }
    
     /**
     * Set descripcion
     *
     * @param string $desc
     * @return Registro
     */
    public function setDescripcion($desc)
    {
        $this->descripcion= $desc;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
     /**
     * Set fechaUltimaActualizacion
     *
     * @param \DateTime $fechaUltimaActualizacion
     * @return Registro
     */
    public function setFechaUltimaActualizacion($fechaUltimaActualizacion)
    {
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion;

        return $this;
    }

    /**
     * Get fechaUltimaActualizacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fechaUltimaActualizacion;
    }
    
     /**
     * Set revisionActual
     *
     * @param integer $revisionActual
     * @return Documento
     */
    public function setRevisionActual($revisionActual)
    {
        $this->revisionActual = $revisionActual;

        return $this;
    }

    /**
     * Get revisionActual
     *
     * @return integer 
     */
    public function getRevisionActual()
    {
        return $this->revisionActual;
    }
    
    public function getAlcances()
    {   
        return $this->alcances;
    }
    public function setAlcances($alcance)
    {
        $this->alcances = $alcance;
        return $this;
    }    
    
    
        
    public function getAlcancesEditor()
    {   
        return $this->alcancesEditor;
    }
    public function setAlcancesEditor($alcance)
    {
        $this->alcancesEditor = $alcance;
        return $this;
    }    
    
    
}
