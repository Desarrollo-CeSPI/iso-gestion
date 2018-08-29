<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoCampo
 */
class TipoCampoValor
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tipoCampoId;

    
    private $valor;
    
    private $texto;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

/*
    1	Texto
    2	Fecha
    3	Usuarios
    4   Numero
*/

    public function getValor()
    {
       return $this->valor;
    }



    /**
     * Set valor
     *
     * @param string $valor
     * @return TipoCampoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }


    
     public function getTexto()
    {
       return $this->texto;
    }



    /**
     * Set texto
     *
     * @param string $valor
     * @return TipoCampoValor
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }
    
    
    
    
    
     public function getTipoCampoId()
    {
       return $this->tipoCampoId;
    }



    /**
     * Set TipoCampoId
     *
     * @param string $valor
     * @return TipoCampoValor
     */
    public function setTipoCampoId($valor)
    {
        $this->tipoCampoId = $valor;

        return $this;
    }
}
