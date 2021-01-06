<?php

namespace App\Repository;

use App\Entity\Rqst;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rqst|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rqst|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rqst[]    findAll()
 * @method Rqst[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RqstRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rqst::class);
    }

    // /**
    //  * @return Rqst[] Returns an array of Rqst objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rqst
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
