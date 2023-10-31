<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FiliereFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
          $filieres=["MAE","IAGE","GLRS"];
        for ($i = 0; $i <count($filieres); $i++) {
             $pos= rand(0,2);
            $data = new Filiere();
            $data->setLibelle($filieres[$i]);
            $manager->persist($data);
            $this->addReference("Filiere".$i, $data);
        }
            $manager->flush();
       }


    
}
