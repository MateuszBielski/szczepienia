<?php

namespace App\Repository;

use App\Entity\Szczepiacy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Szczepiacy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Szczepiacy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Szczepiacy[]    findAll()
 * @method Szczepiacy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SzczepiacyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Szczepiacy::class);
    }

    // /**
    //  * @return Szczepiacy[] Returns an array of Szczepiacy objects
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
    public function findOneBySomeField($value): ?Szczepiacy
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
