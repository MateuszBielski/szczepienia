<?php

namespace App\Repository;

use App\Entity\Osoba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Osoba|null find($id, $lockMode = null, $lockVersion = null)
 * @method Osoba|null findOneBy(array $criteria, array $orderBy = null)
 * @method Osoba[]    findAll()
 * @method Osoba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OsobaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Osoba::class);
    }

    // /**
    //  * @return Osoba[] Returns an array of Osoba objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Osoba
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
