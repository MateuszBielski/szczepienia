<?php

namespace App\Repository;

use App\Entity\KalendarzSzczepien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method KalendarzSzczepien|null find($id, $lockMode = null, $lockVersion = null)
 * @method KalendarzSzczepien|null findOneBy(array $criteria, array $orderBy = null)
 * @method KalendarzSzczepien[]    findAll()
 * @method KalendarzSzczepien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KalendarzSzczepienRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KalendarzSzczepien::class);
    }

    // /**
    //  * @return KalendarzSzczepien[] Returns an array of KalendarzSzczepien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KalendarzSzczepien
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
