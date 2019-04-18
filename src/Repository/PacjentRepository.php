<?php

namespace App\Repository;

use App\Entity\Pacjent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pacjent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pacjent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pacjent[]    findAll()
 * @method Pacjent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PacjentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pacjent::class);
    }

    // /**
    //  * @return Pacjent[] Returns an array of Pacjent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pacjent
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
