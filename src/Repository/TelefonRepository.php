<?php

namespace App\Repository;

use App\Entity\Telefon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Telefon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telefon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telefon[]    findAll()
 * @method Telefon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelefonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Telefon::class);
    }

    // /**
    //  * @return Telefon[] Returns an array of Telefon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telefon
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
