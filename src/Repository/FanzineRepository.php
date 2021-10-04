<?php

namespace App\Repository;

use App\Entity\Fanzine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fanzine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fanzine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fanzine[]    findAll()
 * @method Fanzine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FanzineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fanzine::class);
    }

    // /**
    //  * @return Fanzine[] Returns an array of Fanzine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fanzine
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
