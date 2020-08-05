<?php

namespace App\Repository;

use App\Entity\Mesage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mesage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mesage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mesage[]    findAll()
 * @method Mesage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mesage::class);
    }

    // /**
    //  * @return Mesage[] Returns an array of Mesage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mesage
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
