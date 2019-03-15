<?php

namespace App\Repository;

use App\Entity\Schemat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Schemat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schemat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schemat[]    findAll()
 * @method Schemat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchematRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Schemat::class);
    }

    // /**
    //  * @return Schemat[] Returns an array of Schemat objects
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
    public function findOneBySomeField($value): ?Schemat
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
