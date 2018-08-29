<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento
 */
class Documento
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
     * @var string
     */
    private $ruta;

    /**
     * @var integer
     */
    private $revision;

    /**
     * @var integer
     */
    private $estado;

    /**
     * @var \DateTime
     */
    private $fechaAprobado;

    /**
     * @var \DateTime
     */
    private $fechaRevision;

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     */
    private $fechaVigencia;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * @var integer
     */
    private $editor;
    /**
     * @var integer
     */
    private $revisor; 
    /**
     * @var integer
     */
    private $audiencia;
    /**
     * @var integer
     */
    private $aprobador;
    /**
     * @var integer
     */
    private $responsable;
    /**
     * @var integer
     */        
    private $alcances;
    
    
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
     * @return Documento
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
     * Set ruta
     *
     * @param string $ruta
     * @return Documento
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set revision
     *
     * @param integer $revision
     * @return Documento
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
     * Set estado
     *
     * @param integer $estado
     * @return Documento
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaAprobado
     *
     * @param \DateTime $fechaAprobado
     * @return Documento
     */
    public function setFechaAprobado($fechaAprobado)
    {
        $this->fechaAprobado = $fechaAprobado;

        return $this;
    }

    /**
     * Get fechaAprobado
     *
     * @return \DateTime 
     */
    public function getFechaAprobado()
    {
        return $this->fechaAprobado;
    }

    /**
     * Set fechaRevision
     *
     * @param \DateTime $fechaRevision
     * @return Documento
     */
    public function setFechaRevision($fechaRevision)
    {
        $this->fechaRevision = $fechaRevision;

        return $this;
    }

    /**
     * Get fechaRevision
     *
     * @return \DateTime 
     */
    public function getFechaRevision()
    {
        return $this->fechaRevision;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Documento
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaVigencia
     *
     * @param \DateTime $fechaVigencia
     * @return Documento
     */
    public function setFechaVigencia($fechaVigencia)
    {
        $this->fechaVigencia = $fechaVigencia;

        return $this;
    }

    /**
     * Get fechaVigencia
     *
     * @return \DateTime 
     */
    public function getFechaVigencia()
    {
        return $this->fechaVigencia;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Documento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

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
     * Set tipo
     *
     * @param integer $tipo
     * @return Documento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    public function getRevisor()
    {
        return $this->revisor;
    }
    
    public function getEditor()
    {
        return $this->editor;
    }
    public function getAudiencia()
    {
        return $this->audiencia;
    }
    
    public function getResponsable()
    {
        return $this->responsable;
    }
    public function getAprobador()
    {
        return $this->aprobador;
    }    
        
     
    public function setRevisor($revisor)
    {
        $this->revisor = $revisor;
        return $this;
    }
    
    public function setEditor($editor)
    {
       $this->editor = $editor;
       return $this;
    }
    public function setAudiencia($audiencia)
    {
        $this->audiencia = $audiencia;
        return $this;
    }
    
    public function setResponsable($responsable)
    {   
        $this->responsable = $responsable;
        return $this;
    }
    public function setAprobador($aprobador)
    {
        $this->aprobador = $aprobador;
        return $this;
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
    
    
    
}
