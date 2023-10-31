<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ClasseFixtures extends Fixture implements
DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $pos= rand(0,2);
            $data = new Classe();
           
            $filiere= $this->getReference("Filiere". $pos);
            $niveau= $this->getReference("Niveau". $pos);

            $data->setLibelle($niveau->getLibelle()."".$filiere->getLibelle());
            $data->setFiliere( $filiere);
            $data->setNiveau( $niveau);
            $manager->persist($data);
            $this->addReference("Classe".$i, $data);
       }

        $manager->flush();
    }

    public function getDependencies()
   {
    return array(
        FiliereFixtures::class,
        NiveauFixtures::class
  ); 

}
}
