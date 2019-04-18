<?php

namespace App\Repository;

use App\Entity\NastepnaOsoba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NastepnaOsoba|null find($id, $lockMode = null, $lockVersion = null)
 * @method NastepnaOsoba|null findOneBy(array $criteria, array $orderBy = null)
 * @method NastepnaOsoba[]    findAll()
 * @method NastepnaOsoba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NastepnaOsobaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NastepnaOsoba::class);
    }

    // /**
    //  * @return NastepnaOsoba[] Returns an array of NastepnaOsoba objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NastepnaOsoba
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
