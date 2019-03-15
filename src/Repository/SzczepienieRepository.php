<?php

namespace App\Repository;

use App\Entity\Szczepienie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Szczepienie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Szczepienie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Szczepienie[]    findAll()
 * @method Szczepienie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SzczepienieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Szczepienie::class);
    }

    // /**
    //  * @return Szczepienie[] Returns an array of Szczepienie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Szczepienie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
