<?php

namespace App\Repository;

use App\Entity\ChoisirReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChoisirReponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChoisirReponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChoisirReponse[]    findAll()
 * @method ChoisirReponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoisirReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChoisirReponse::class);
    }

    // /**
    //  * @return ChoisirReponse[] Returns an array of ChoisirReponse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChoisirReponse
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
