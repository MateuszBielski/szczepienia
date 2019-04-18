<?php

namespace App\Repository;

use App\Entity\Dawka;
use App\Entity\Szczepionka;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dawka|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dawka|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dawka[]    findAll()
 * @method Dawka[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DawkaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dawka::class);
    }

    // /**
    //  * @return Dawka[] Returns an array of Dawka objects
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
    public function findOneBySomeField($value): ?Dawka
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function znajdzWgSzczepionki(Szczepionka $szczep)
    {
                /*return $this->createQueryBuilder('cat')
            ->andWhere('cat.name LIKE :searchTerm
                OR cat.iconKey LIKE :searchTerm
                OR fc.fortune LIKE :searchTerm')
            ->leftJoin('cat.fortuneCookies', 'fc')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->getQuery()
            ->execute();*/
        
        return $this->createQueryBuilder('daw')
            ->andWhere('ska.id = :id')
            ->leftJoin('daw.schemat', 'sch')
            ->leftJoin('sch.podawania', 'ska')
            ->setParameter('id', $szczep->getId())
            ->orderBy('daw.id','ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
