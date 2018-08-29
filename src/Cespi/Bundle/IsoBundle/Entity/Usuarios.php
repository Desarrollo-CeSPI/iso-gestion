<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 */

class Usuarios implements UserInterface, \Serializable
{
     /**
     * @var string
     */
    protected $salt;
    /**
     * @var string
     */
    protected $person_id;
     /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

     /**
     * @var string
     */
    private $password;
    
    /**
     * @var string
     */
    private $apellido;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $nroDocumento;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $perfil;
    
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
     * Set username
     *
     * @param string $username
     * @return Usuarios
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

     /**
     * Set password
     *
     * @param string $password
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuarios
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
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
     * Set nroDocumento
     *
     * @param string $nroDocumento
     * @return Usuarios
     */
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;

        return $this;
    }

    /**
     * Get nroDocumento
     *
     * @return string 
     */
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set perfil
     *
     * @param string $perfil
     * @return Usuarios
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return string 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
    
  
    public function __toString()
    {
        return $this->apellido." ".$this->nombre;
    }

    public function getNombreCompleto () 
    {
        return $this->apellido." ".$this->nombre;
    }


    public function eraseCredentials() {
        
    }
   
    public function getRoles() {
        return array($this->getPerfil());
        /*if (!$this->getPerfil()) { return array('ROLE_USER'); }
        else return array($this->getPerfil());*/
    }

    public function getSalt() {
         return '';
    }
    
    public function setSalt($salt) {
         $this->salt = '';
    }
    
    public function esAdmin() {
        // ESTO NO ANDA
        if  ($this->perfil == "ROLE_ADMIN"){
            return true;
        }else{
            return false;
        
        }
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

    
     /**
     * @return string
     */
    public function serialize()
    { 
       
      $roles = $this->getRoles();
      return serialize(array($this->username, $this->password, $this->salt,
                        $roles, $this->id,$this->nombre,$this->apellido));
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
      //$roles = $this->getRoles();
      list($this->username, $this->password, $this->salt,
                        $this->perfil, $this->id,$this->nombre,$this->apellido) = unserialize($data);
            
    }
    
    public function __construct($username = null, $roles=null, $id=null)
    {
       $this->username = $username; 
       $this->perfil = $roles[0];
       $this->id = $id;
        
    }
    
}
