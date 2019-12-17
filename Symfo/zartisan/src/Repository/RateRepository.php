<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    /**
    * @return [] Returns an array of User objects
    */
    public function findByUserPro($userPro)
    {
        $result = $this->createQueryBuilder('r')
        ->join('r.userAuthor', 'u')
        ->andwhere('u.isStatus = :isStatus')
        ->andwhere('r.userPro = :userPro')
        ->setParameter('userPro', $userPro)
        ->setParameter('isStatus', TRUE)
        ->select('r.value')
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result;
        }
    }

    public function isFoundRate($userPro){
        $result = $this->createQueryBuilder('r')
                ->andWhere('r.userPro = :userPro')
                ->setParameter('userPro', $userPro)
                ->OrderBy('r.createdAt', 'ASC');
      
        return $result->getQuery()->getResult();
    }


    public function isFoundRateByUser($userPro, $userAuthor){
        $result = $this->createQueryBuilder('r')
                ->andWhere('r.userPro = :userPro')
                ->setParameter('userPro', $userPro)
                ->andWhere('r.userAuthor = :userAuthor')
                ->setParameter('userAuthor', $userAuthor);
      
        return $result->getQuery()->getResult();
    }

}
