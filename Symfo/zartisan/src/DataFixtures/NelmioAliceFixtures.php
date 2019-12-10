<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\Alice\Loader\NativeLoader;

class NelmioAliceFixtures extends Fixture
{
    private $nativeLoader;

    public function __construct(NativeLoader $nativeLoader)
    {
        $this->nativeLoader = $nativeLoader;
    }

    public function load(EntityManagerInterface $em, UserFixture $userFixture)
    {
        $userFixture->setUser();

        //importe le fichier de fixtures et récupère les entités générés
        $entities = $this->nativeLoader->loadFile(__DIR__.'/fixtures.yaml')->getObjects();    
        
        foreach ($entities as $entity) {
            $em->persist($entity);
        };
        
        //enregistre
        $em->flush();
    }
}
