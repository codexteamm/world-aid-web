<?php


namespace AssociationBundle\Repository;


class evenementRepository extends \Doctrine\ORM\EntityRepository
{
    public function myfindid($id)
    {
        $qb = $this->createQueryBuilder('c');
        $query =     $qb->where('c.idassociation = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $results = $query->getResult();
    }

}