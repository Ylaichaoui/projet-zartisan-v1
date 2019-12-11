<?php
namespace App\DataFixtures;

use Nelmio\Alice\Loader\NativeLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NelmioAliceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $loader = new NativeLoader();
        $entities = $loader->loadFile(__DIR__.'/fixtures.yaml')->getObjects();
        foreach ($entities as $entity) {
            $manager->persist($entity);
        };
      
        $manager->flush();
    }
}