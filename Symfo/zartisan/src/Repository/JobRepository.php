<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
    * @return Job Returns an array of Job objects
    */
    public function isFound(string $name)
    {
        $result = $this->createQueryBuilder('j')
        ->where('j.name = :name')
        ->setParameter('name', $name)
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result[0];
        }
    }

    /**
    * @return Job[] Returns an array of Category objects
    */
    public function findFromCategory(int $category)
    {
        $result = $this->createQueryBuilder('j')
        ->where('j.category = :category')
        ->setParameter('category', $category)
        ->getQuery()
        ->getResult();

        if(!isset($result)){
            return NULL;
        }else{
            return $result;
        }
    }
    
}
