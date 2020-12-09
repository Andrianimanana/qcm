<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    
    public function findQuestionHaveReponse(Category $category)
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.reponses', 're')
            ->leftJoin('q.category', 'ca')
            ->andWhere('q.id = re.question') 
            ->andWhere('q.category = ca.id') 
            ->andWhere('q.category = :category') 
            ->setParameter('category', $category)
            ->orderBy('q.index_question', 'ASC') 
            ->getQuery()
            ->getResult()
        ;
    } 

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
