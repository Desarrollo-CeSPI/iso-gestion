<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Cespi\Bundle\IsoBundle\Entity\Usuario;

class UsuariosRepository extends EntityRepository {

    public function getByUserName($username) {
        

        $q = $this->createQueryBuilder('a')->select('a');
        $q = $q->where('a.username = :username');
        $q = $q->setParameter('username', $username);
        
        return $q->getQuery()->getResult();
    }
    
    public function getByEmail($email) {
        
        $q = $this->createQueryBuilder('a')->select('a');
        $q = $q->where('a.email = :email');
        $q = $q->setParameter('email', $email);
        
        return $q->getQuery()->getResult();
    }
    
    public function findAllByAlcances ($alcances) {
        
       
        
        $q = $this->createQueryBuilder('a')->select('a')
                  ->innerJoin('a.alcances', 'g')
                  ->where('g.id IN (:alcances)')
                  ->setParameter('alcances', $alcances);
        
        return $q->getQuery()->getResult();
    }
    


    
    
    
}
