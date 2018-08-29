<?php

namespace Cespi\Bundle\IsoBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SamlUserProvider extends \Hslavich\OneloginSamlBundle\Security\User\SamlUserProvider
{
    protected $userClass;
    protected $defaultRoles;

    public function __construct(\Doctrine\ORM\EntityManager $em=null, $userClass, array $defaultRoles)
    {
        $this->userClass = $userClass;
        $this->defaultRoles = $defaultRoles;
        $this->em = $em;
    }

    public function loadUserByUsername($username)
    {
            $usuario = new $this->userClass($username, $this->defaultRoles);
    
            $u = $this->em->getRepository('CespiIsoBundle:Usuarios')->getByUserName($username); 
            //$idUsuario = 1;
            if ($u) {
                    $user_serialized = $u[0]->serialize();
                    $alcances = $u[0]->getAlcances();
                    $usuario->unserialize($user_serialized);
                    $usuario->setAlcances($alcances);
            }              
                          
            return $usuario;
            //return new $this->userClass($username, $this->defaultRoles, $idUsuario) ;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $this->userClass === $class || is_subclass_of($class, $this->userClass);
    }
    
    
}
