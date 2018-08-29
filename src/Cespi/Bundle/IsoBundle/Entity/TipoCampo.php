<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoCampo
 */
class TipoCampo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tipo;

     /**
     * @ORM\ManyToMany(targetEntity="Registro", inversedBy="tipoCampo")
     * @ORM\JoinTable(name="registro_campos")
     **/
    
    private $Registro;
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

    public function getWidget($usuarios)
    {
        
        
                
        switch ($this->getTipo()) {
            
        case 'Texto':
            return  array ('text',array() );  
        
        break;
        
        case 'Fecha':
            return   array ('text', array(
                /*'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',*/
            ));
        break;        

        case 'Usuarios':
           
            return  array ('choice',array(
                                'choices'   => $usuarios,
                                'multiple'  => true,
                            )
                            
                    );

        break;   
        
        case 'Numero':
             return  array ('number',array());
        break;        
        
        case 'Tabulado':
            return  array ('choice',array('multiple' => true) );  
        case 'Tipo':
        case 'Estado':            
            return  array ('choice',array() );  
        break;
        default:
          
            return  array ('text',array());
        
        
        }
}



    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TipoCampo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
     
    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TipoCampo
     */
    public function setRegistro($registro)
    {
        $this->Registro = $registro;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getRegistro()
    {
        return $this->Registro;
    }
    
    public function __toString() {
        return $this->getTipo();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Registro = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add Registro
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Registro $registro
     * @return TipoCampo
     */
    public function addRegistro(\Cespi\Bundle\IsoBundle\Entity\Registro $registro)
    {
        $this->Registro[] = $registro;

        return $this;
    }

    /**
     * Remove Registro
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\Registro $registro
     */
    public function removeRegistro(\Cespi\Bundle\IsoBundle\Entity\Registro $registro)
    {
        $this->Registro->removeElement($registro);
    }
    
    

}
