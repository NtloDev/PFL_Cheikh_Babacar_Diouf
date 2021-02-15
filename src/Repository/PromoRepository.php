<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promo[]    findAll()
 * @method Promo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }
    public function findPromobyGrpPrincipal()
    {
        return $this->createQueryBuilder('p')
            ->select('p,g')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.Type = :val')
            ->setParameter('val', 'Principal')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findPromobyApprenantsAttente()
    {
        return $this->createQueryBuilder('p')
            ->select('p,a')
            ->leftJoin('p.Apprenants','a')
            ->andWhere('a.Statut = :stat')
            ->setParameter('stat', 'Attente')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findOnePromobyApprenantsAttente($i)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->Where('p.id = :val')
            ->setParameter('val', $i)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    // /**
    //  * @return Promo[] Returns an array of Promo objects
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
    public function findOneBySomeField($value): ?Promo
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
