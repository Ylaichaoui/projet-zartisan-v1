<?php

namespace App\Manager;

use App\Entity\Advice;
use App\Entity\Rate;
use App\Entity\User;
use App\Manager\ApiSireneManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManualFixtureManager
{
    private $siretArray = [
        '81137220000014',
        '97150365100012',
        '82476901200025',
        '82523315800013',
        '42877456600023',
        '84768744900011',
        '30508057400067',
        '81829751700026',
        '43032153900032',
        '34114986200029',
        '34828961200023',
        '80527347100013',
        '09412947500011',
        '79811363500022',
        '01625052400028',
        '32449988800018',
        '43972887400017',
        '77963443500019',
        '82801885300014',
        '81765596200014',
        '75318828300018',
        '35022955500056',
        '84934201900015',
        '30166866100095',
        '43394566400012'
    ];

    private $emailArray = [
        'admin@msn.com',
        'user@msn.com',
        'artisan@msn.com',
        'pierre@msn.com',
        'jean@msn.com',
        'eveline@msn.com',
        'denise@msn.com',
        'alissa@msn.com',
        'stephanie@msn.com',
        'pierrot@msn.com',
        'claude@msn.com',
        'ethan@msn.com',
        'nicole@msn.com',
        'vincent@msn.com',
        'maude@msn.com',
        'audrey@msn.com',
        'jacky@msn.com',
        'paul@msn.com',
        'odille@msn.com',
        'sophie@msn.com',
        'lechat@msn.com',
        'lapierre@msn.com',
        'lechien@msn.com',
        'fred@msn.com',
        'pauline@msn.com'
    ];

    private $role = [
        "ROLE_USER",
        "ROLE_ARTISAN",
        "ROLE_ADMIN"
    ];

    private $apiSireneManager;
    private $passwordEncoder;
    private $em;
    private $userRepository;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, ApiSireneManager $apiSireneManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->apiSireneManager = $apiSireneManager;
        $this->passwordEncoder= $passwordEncoder;
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    public function setFixtureUser($index){
        $user = new User();
        
        // Program to set 1st admin & 2nd user & 3rd artisan after is random
        if($index > 2){
            $user->setRoles([$this->role[rand(0,2)]]);
        }elseif($index == 2){
            $user->setRoles(["ROLE_ARTISAN"]);
        }elseif($index == 1){
            $user->setRoles(["ROLE_USER"]);
        }else{
            $user->setRoles(["ROLE_ADMIN"]);
        }

        if (in_array("ROLE_ARTISAN", $user->getRoles())) {  
            $user->setSiret($this->siretArray[$index]);
        }
        $user->setEmail($this->emailArray[$index]);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                '123456'
            )
        );
        $user->setIsConfirmMail((bool)random_int(0,1));
        $user->setAverageRate(random_int(0,5));
        $user->setIsStatus((bool)random_int(0,1));
        $user->setIsVerified((bool)random_int(0,1));
        $user->setIsReported((bool)random_int(0,1));
        $this->em->persist($user);
        $this->em->flush();

        if (in_array("ROLE_ARTISAN", $user->getRoles())) {
            $user = $this->apiSireneManager->setSireneDataApi($this->siretArray[$index]);
        }
        $user->setPhone('0344566360');
        return $user;
    }

    public function setFixtureRate(){
        $author = $this->userRepository->findUser();
        $pro =  $this->userRepository->findArtisan();

        shuffle($author);
        shuffle($pro);
        $rate = new Rate();
        $rate->setValue(random_int(0,5));
        $rate->setUserAuthor($author[0]);
        $rate->setUserPro($pro[0]);
        return $rate;
    }

    public function setFixtureAdvice(){
        $author = $this->userRepository->findUser();
        $pro =  $this->userRepository->findArtisan();

        shuffle($author);
        shuffle($pro);
        $advice = new Advice();
        $advice->setBody("Ceci est un advice mis part une personne !");
        $advice->setIsStatus((bool)random_int(0,1));
        $advice->setIsReported((bool)random_int(0,1));
        $advice->setUserAuthor($author[0]);
        $advice->setUserPro($pro[0]);
        return $advice;
    }

    public function load()
    {
        // Create 14 users (need existing siret and mail & unique)
        for($i=0;$i<= 14;$i++){
            $user = $this->setFixtureUser($i);
            $this->em->persist($user);
            $this->em->flush();
            if($i > 2){
                $rate = $this->setFixtureRate();
                $this->em->persist($rate);
                $this->em->flush();
                $advice = $this->setFixtureAdvice();
                $this->em->persist($advice);
                $this->em->flush();
            }
        }
    }

}