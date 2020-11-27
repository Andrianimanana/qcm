<?php

namespace App\Repository;

use App\Entity\ChoisirReponse;
use App\Entity\User;
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

    
    // public function getDetailResult(User $user)
    // {
        
    //     return $this->createQueryBuilder('c')
    //         ->select('c')
    //         ->leftJoin('c.question', 'q')
    //         ->leftJoin('c.reponse', 'r')
    //         ->leftJoin('c.user', 'u')
    //         ->andWhere('u.id = :iduser')
    //         ->setParameter('iduser', $user->getId())
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // } 

   
    public function findResults(User $user)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.reponse', 'rep')
            ->andWhere('c.reponse = rep.id')
            ->andWhere('rep.is_true = TRUE')
            ->andWhere('c.user = :iduser')
            ->setParameter('iduser', $user->getId())
            ->getQuery()
            ->getResult() 
        ;
    } 
}
