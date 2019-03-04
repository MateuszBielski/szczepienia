<?php

namespace App\Repository;

use App\Entity\Nazwa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Nazwa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nazwa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nazwa[]    findAll()
 * @method Nazwa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NazwaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Nazwa::class);
    }

    // /**
    //  * @return Nazwa[] Returns an array of Nazwa objects
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
    public function findOneBySomeField($value): ?Nazwa
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
