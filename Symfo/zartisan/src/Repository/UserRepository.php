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
    * @return User[] Returns  an array of User individual list all users
    */
    public function findAllUser()
    {
        $qb = $this->createQueryBuilder('u')
        ->andWhere('u.roles LIKE :role')
        ->andwhere('u.isStatus = :enabled')
        ->setParameter('role', '%"'.'ROLE_USER'.'"%')
        ->setParameter('enabled', true);
        
        return $qb->getQuery()->getResult();
    }

    /**
    * @return User[] Returns an array of Job objects
    */
    public function search(string $job, string $region)
    {
        // TODO select join table job to get the job querry
        $result = $this->createQueryBuilder('u')
                ->andWhere('u.region LIKE :region')
                ->andwhere('u.isStatus = :enabled')
                ->join('u.job', 'j')
                ->andWhere('j.name LIKE :job')
                ->setParameter('job', $job)
                ->setParameter('enabled', TRUE)
                ->setParameter('region', $region)
                ->OrderBy('u.averageRate', 'DESC')
                ->OrderBy('u.isVerified', 'DESC');
      
        return $result->getQuery()->getResult();
    }

    /**
    * @return User Returns an array of User objects
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

    /**
    * @return User Returns an array of User objects
    */
    public function isFoundMail(string $email)
    {
        $result = $this->createQueryBuilder('u')
        ->where('u.email = :email')
        ->setParameter('email', $email)
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result[0];
        }
    }

    /**
    * @return User Returns an array of User objects
    */
    public function isFoundToken(string $mailToken)
    {
        $result = $this->createQueryBuilder('u')
        ->where('u.mailToken = :mailToken')
        ->setParameter('mailToken', $mailToken)
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result[0];
        }
    }

    /**
    * @return User[] Returns an array of User objects
    */
    public function findUser()
    {
        $result = $this->createQueryBuilder('u')
        ->Where('u.roles LIKE :role')
        ->setParameter('role', '%"'.'ROLE_USER'.'"%')
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result;
        }
    }

    /**
    * @return User[] Returns an array of User objects
    */
    public function findArtisan()
    {
        $result = $this->createQueryBuilder('u')
        ->Where('u.roles LIKE :role')
        ->setParameter('role', '%"'.'ROLE_ARTISAN'.'"%')
        ->getQuery()
        ->getResult();

        if(!isset($result[0])){
            return NULL;
        }else{
            return $result;
        }
    }
}
