<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Cespi\Bundle\IsoBundle\Entity\Documento;

class DocumentoRepository extends EntityRepository {

    public function filtros($tipo, $estado) {


        $q = $this->createQueryBuilder('a')->select('a');
        if ($tipo) {
            $q = $q->where('a.tipo = :tipo');
            $q = $q->setParameter('tipo', $tipo);
        }
        if ($estado) {
            if ($tipo) {
                $q = $q->andWhere('a.estado = :estado');
            } else {
                $q = $q->where('a.estado = :estado');
            }
            $q->setParameter('estado', $estado);
        }


        return $q->getQuery()->getResult();
    }

}
