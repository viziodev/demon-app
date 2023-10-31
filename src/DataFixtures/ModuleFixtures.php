<?php

namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ModuleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $module = new Module();
            $module->setLibelle('Module '.$i);
            $manager->persist($module);
            $this->addReference("Module".$i, $module);
        }

        $manager->flush();
    }
}
