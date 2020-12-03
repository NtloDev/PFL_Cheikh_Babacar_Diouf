<?php

namespace App\Repository;

use App\Entity\GroupeDeTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupeDeTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeDeTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeDeTags[]    findAll()
 * @method GroupeDeTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeDeTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeDeTags::class);
    }

    // /**
    //  * @return GroupeDeTags[] Returns an array of GroupeDeTags objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupeDeTags
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
