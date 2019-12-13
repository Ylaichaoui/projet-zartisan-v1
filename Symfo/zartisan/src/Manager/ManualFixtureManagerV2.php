<?php

namespace App\Manager;

use App\Entity\Advice;
use App\Entity\Rate;
use App\Entity\User;
use App\Manager\ApiSireneManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManualFixtureManagerV2
{
    private $siretArray = [
        '81137220000014',
        '97150365100012',
        '82476901200025',
        '82523315800013',
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
        '82801885300014',
        '81765596200014',
        '75318828300018',
        '35022955500056',
        '84934201900015',
        '30166866100095',
        '43394566400012',
        '79055574200028',
        '80422184400025',
        '42852015900024',
        '32746078800034',
        '47874941900055',
        '40055521500013',
        '33506030700055',
        '44449563400016',
        '44460046401836',
        '44010976700028',
        '51853004300018',
        '53438867300012',
        '84987708900011',
        '51292715300043',
        '52946209500025',
        '53498205300017',
        '50800070000031'
    ];

    private $nameArray = [
        'admin',
        'user',
        'artisan',
        'pierre',
        'jean',
        'eveline',
        'denise',
        'alissa',
        'stephanie',
        'pierrot',
        'claude',
        'ethan',
        'nicole',
        'vincent',
        'maud',
        'audrey',
        'jacky',
        'paul',
        'odille',
        'sophie',
        'lechat',
        'lapierre',
        'lechien',
        'fred',
        'pauline',
        'toto',
        'ronald',
        'donald',
        'trump',
        'titi',
        'younes',
        'yassine',
        'bill',
        'loise',
        'denis',
        'jill',
        'mégane',
        'fox',
        'johan',
        'nathan',
        'pinuts',
        'troll'
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
        if($index > 30){
            $user->setRoles(["ROLE_USER"]);
        }
        elseif($index > 2){
            $user->setRoles(["ROLE_ARTISAN"]);
        }elseif($index == 2){
            $user->setRoles(["ROLE_ARTISAN"]);
        }elseif($index == 1){
            $user->setRoles(["ROLE_USER"]);
        }else{
            $user->setRoles(["ROLE_ADMIN"]);
        }

        if (in_array("ROLE_ARTISAN", $user->getRoles())) {
            $user->setPicture("company".random_int(1,6).".png");
            $user->setSiret($this->siretArray[$index]);
        }

        if($index < 2){
            $user->setEmail($this->nameArray[$index]."@msn.com");
        }else{
            $user->setEmail($this->nameArray[random_int(0,40)].$this->nameArray[random_int(0,40)].$this->nameArray[random_int(0,40)]."@msn.com");
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                '123456'
            )
        );
        if (in_array("ROLE_USER", $user->getRoles())) {
            $user->setPicture("user".random_int(1,6).".png"); 
            $user->setFirstname($this->nameArray[random_int(0,40)]);
            $user->setLastname($this->nameArray[random_int(0,40)]);
            $user->setNickname($this->nameArray[random_int(0,40)]." ".$this->nameArray[random_int(0,40)]);
            $user->setPhone('0344566360');
        }
        $user->setIsConfirmMail(0);
        $user->setAverageRate(random_int(0,5));
        $user->setIsStatus(1);
        $user->setIsVerified(0);
        $user->setIsReported(0);
        $this->em->persist($user);
        $this->em->flush();

        if (in_array("ROLE_ARTISAN", $user->getRoles())) {
            $user = $this->apiSireneManager->setSireneDataApi($this->siretArray[$index]);
        }
        
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
        $advice->setBody("Ceci est un advice mis part ".$author[0]." pour ".$pro[0]);
        $advice->setIsStatus(1);
        $advice->setIsReported(0);
        $advice->setUserAuthor($author[0]);
        $advice->setUserPro($pro[0]);
        return $advice;
    }

    public function load()
    {
        // Create 60 users (need existing siret and mail & unique)
        for($i=0;$i<= 60;$i++){
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