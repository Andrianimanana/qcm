<?php

/**
 * @Author: Armel Andrianimanana
 * @Date:   2020-11-23 12:33:12
 * @Last Modified by:   Armel
 * @Last Modified time: 2020-12-15 11:58:25
 */
namespace App\Repository;

use App\Entity\Category;
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
   
    public function findLastReponse(User $user, Category $category) : ?ChoisirReponse
    {
        return $this->createQueryBuilder('c') 
            ->leftJoin('c.question', 'q') 
            ->andWhere('c.question = q.id')
            ->andWhere('c.user = :iduser')
            ->andWhere('q.category  = :category')
            ->setParameter('iduser', $user->getId())
            ->setParameter('category', $category->getId()) 
            ->orderBy('q.index_question', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    } 
}
