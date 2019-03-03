<?php

namespace App\Repository;

use App\Entity\Choroba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Choroba|null find($id, $lockMode = null, $lockVersion = null)
 * @method Choroba|null findOneBy(array $criteria, array $orderBy = null)
 * @method Choroba[]    findAll()
 * @method Choroba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChorobaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Choroba::class);
    }

    // /**
    //  * @return Choroba[] Returns an array of Choroba objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Choroba
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
