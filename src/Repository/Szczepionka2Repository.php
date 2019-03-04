<?php

namespace App\Repository;

use App\Entity\Szczepionka2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Szczepionka2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Szczepionka2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Szczepionka2[]    findAll()
 * @method Szczepionka2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Szczepionka2Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Szczepionka2::class);
    }

    // /**
    //  * @return Szczepionka2[] Returns an array of Szczepionka2 objects
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
    public function findOneBySomeField($value): ?Szczepionka2
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
