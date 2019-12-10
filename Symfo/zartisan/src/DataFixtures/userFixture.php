<?php

namespace App\Controller;

use App\Manager\ApiSireneManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\ApiSireneManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;




class NelmioAliceFixtures extends Fixture
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

    private $externeApiController;

    public function __construct(ExterneApiController $externeApiController)
    {
        $this->externeApiController = $externeApiController;
    }

    public function setUser(){

        foreach($siretArray as $siret){

            $user = $this->externeApiController->ApiIndexSirene($siretArray);
        }
    }
}<?php




class NelmioAliceFixtures extends Fixture
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

    private $externeApiController;

    public function __construct(ExterneApiController $externeApiController)
    {
        $this->externeApiController = $externeApiController;
    }

    public function setUser(){

        foreach($siretArray as $siret){

            $user = $this->externeApiController->ApiIndexSirene($siretArray);
        }
    }
}<?php




class NelmioAliceFixtures extends Fixture
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

    private $externeApiController;

    public function __construct(ExterneApiController $externeApiController)
    {
        $this->externeApiController = $externeApiController;
    }

    public fucntion setUser(){

    }
}