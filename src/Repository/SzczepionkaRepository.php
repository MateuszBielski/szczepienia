<?php

namespace App\Repository;

use App\Entity\Szczepionka;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Szczepionka|null find($id, $lockMode = null, $lockVersion = null)
 * @method Szczepionka|null findOneBy(array $criteria, array $orderBy = null)
 * @method Szczepionka[]    findAll()
 * @method Szczepionka[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SzczepionkaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Szczepionka::class);
    }

    // /**
    //  * @return Szczepionka[] Returns an array of Szczepionka objects
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
    public function findOneBySomeField($value): ?Szczepionka
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function znajdzPierwszaZlisty(): ?Szczepionka
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id','ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
