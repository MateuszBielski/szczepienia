<?php

namespace App\Repository;

use App\Entity\Grupa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Grupa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grupa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grupa[]    findAll()
 * @method Grupa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrupaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grupa::class);
    }

    // /**
    //  * @return Grupa[] Returns an array of Grupa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grupa
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
