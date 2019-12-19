<?php

namespace App\Repository;

use App\Entity\Advice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Advice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advice[]    findAll()
 * @method Advice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advice::class);
    }

    /**
    * @return Advice[] Returns an array of Advice objects
    */
    public function isFoundAdvice($userPro){
        $result = $this->createQueryBuilder('a')
                ->andWhere('a.userPro = :userPro')
                ->andwhere('a.isStatus = :isStatus')
                ->setParameter('userPro', $userPro)
                ->setParameter('isStatus', TRUE)
                ->OrderBy('a.createdAt', 'DESC');
      
        return $result->getQuery()->getResult();
    }

}
