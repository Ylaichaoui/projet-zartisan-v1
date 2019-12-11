<?php

namespace App\DataFixtures;

use App\Manager\ApiSireneManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class userFixture extends  \Faker\Provider\Base
{
    protected static $siretArray = [
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

    protected static $emailArray = [
        'jupiteralonedenie@msn.com',
        'jupiteralonedenid@msn.com',
        'jupiteralonedened@msn.com',
        'jupiteralonedeied@msn.com',
        'jupiteraloneenied@msn.com',
        'jupiteralondenied@msn.com',
        'jupiteraloedenied@msn.com',
        'jupiteralnedenied@msn.com',
        'jupiteraonedenied@msn.com',
        'jupiterlonedenied@msn.com',
        'jupitealonedenied@msn.com',
        'jupitralonedenied@msn.com',
        'jupieralonedenied@msn.com',
        'jupteralonedenied@msn.com',
        'juiteralonedenied@msn.com',
        'jpiteralonedenied@msn.com',
        'upiteralonedenied@msn.com',
        'jupiteralonedeni@msn.com',
        'jupiteralonedend@msn.com',
        'jupiteralonedeed@msn.com',
        'jupiteralonedied@msn.com',
        'jupiteralnenied@msn.com',
        'jupiteralonenied@msn.com',
        'jupiteralodenied@msn.com',
        'jupiteraledenied@msn.com'
    ];

    private $apiSireneManager;
    private $passwordEncoder;
    private $em;

    public function __construct(ApiSireneManager $apiSireneManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->apiSireneManager = $apiSireneManager;
        $this->passwordEncoder = $passwordEncoder;
       
    }

    public function setUser(){

        foreach($this->siretArray as $index => $siret){
            $user = $this->apiSireneManager->setSireneDataApi($siret);
            $user->setPhone(0344566325);
            $user->setEmail($this->emailArray[$index]);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    '123456'
                )
            );

        }
    }
}