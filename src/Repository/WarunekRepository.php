<?php

namespace App\Repository;

use App\Entity\Warunek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Warunek|null find($id, $lockMode = null, $lockVersion = null)
 * @method Warunek|null findOneBy(array $criteria, array $orderBy = null)
 * @method Warunek[]    findAll()
 * @method Warunek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarunekRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Warunek::class);
    }

    // /**
    //  * @return Warunek[] Returns an array of Warunek objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Warunek
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
