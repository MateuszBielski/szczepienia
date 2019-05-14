<?php

namespace App\Repository;

use App\Entity\Schemat;
use App\Entity\Szczepionka;
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
    public function znajdzIleDlaSzczepionki(integer $ile, Szczepionka $szczep)
    {
                   
        return $this->createQueryBuilder('sch')
            ->andWhere('ska.id = :id')
            ->leftJoin('sch.podawania', 'ska')
            ->setParameter('id', $szczep->getId())
            ->getQuery()
            ->execute();
    }
    
    public function findAllOrderByStartYearSzczepionkaNazwa(){
         return $this->createQueryBuilder('sch')
            //->andWhere('ska.id = :id')
            ->leftJoin('sch.podawania', 'ska')
            //->setParameter('id', $szczep->getId())
            ->addOrderBy('ska.nazwa', 'ASC')
            ->addOrderBy('sch.startYear', 'ASC')
            
            ->getQuery()
            ->execute();
    }
    
}
