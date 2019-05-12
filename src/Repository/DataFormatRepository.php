<?php

namespace App\Repository;

use App\Entity\DataFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DataFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataFormat[]    findAll()
 * @method DataFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataFormatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DataFormat::class);
    }

    // /**
    //  * @return DataFormat[] Returns an array of DataFormat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DataFormat
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
