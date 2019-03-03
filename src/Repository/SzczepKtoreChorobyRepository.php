<?php

namespace App\Repository;

use App\Entity\SzczepKtoreChoroby;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SzczepKtoreChoroby|null find($id, $lockMode = null, $lockVersion = null)
 * @method SzczepKtoreChoroby|null findOneBy(array $criteria, array $orderBy = null)
 * @method SzczepKtoreChoroby[]    findAll()
 * @method SzczepKtoreChoroby[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SzczepKtoreChorobyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SzczepKtoreChoroby::class);
    }

    // /**
    //  * @return SzczepKtoreChoroby[] Returns an array of SzczepKtoreChoroby objects
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
    public function findOneBySomeField($value): ?SzczepKtoreChoroby
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
