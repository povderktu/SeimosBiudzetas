<?php

namespace App\Repository;

use App\Entity\ExpanseType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExpanseType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpanseType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpanseType[]    findAll()
 * @method ExpanseType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpanseTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpanseType::class);
    }

    // /**
    //  * @return ExpanseType[] Returns an array of ExpanseType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpanseType
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
