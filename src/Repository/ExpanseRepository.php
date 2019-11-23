<?php

namespace App\Repository;

use App\Entity\Expanse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Expanse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expanse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expanse[]    findAll()
 * @method Expanse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpanseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Expanse::class);
    }



    public function removeCreatedP($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->delete('SeimosAppEntity:Expanse', 'p')
            ->where('p.member = :id')
            ->setParameter('id', '$id')
            ->getQuery();


        return $qb->execute();
    }

    // /**
    //  * @return Expanse[] Returns an array of Expanse objects
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
    public function findOneBySomeField($value): ?Expanse
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
