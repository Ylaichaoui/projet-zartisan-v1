<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixture;
use App\Controller\ExterneApiController;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class NelmioAliceFixtures extends Fixture
{

    public function load(ObjectManager $em)
    {
        $loader = new NativeLoader();
        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__.'/fixtures.yaml')->getObjects();    
        
        foreach ($entities as $entity) {
            $em->persist($entity);
        };
        
        //enregistre
        $em->flush();
    }
}
