<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
    * @return User[] Returns an array of User objects
    */
    public function isFound(int $siret)
    {
        $result = $this->createQueryBuilder('u')
        ->where('u.siret = :siret')
        ->setParameter('siret', $siret)
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result[0];
        }
    }
}
