<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use App\DataFixtures\ClasseFixtures;
use App\DataFixtures\EtudiantFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\AnneeScolaireFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
         for ($i = 1; $i <=100; $i++) {
                  $annee=rand(2019,2022);
                  $pos=rand(1,10);
                  $data=new Inscription();
                  $data->setAnneeScolaire($this->getReference("AnneeScolaire".$annee));
                  $data->setClasse($this->getReference("Classe".$pos));
                  $data->setEtudiant($this->getReference("Etudiant".$pos));
                  $manager->persist($data);
                  $this->addReference("Inscription".$i,$data);
           }
              $manager->flush();
      
         }
         public function getDependencies(){
             return array(
                EtudiantFixtures::class,
                ClasseFixtures::class,
                AnneeScolaireFixtures::class
              ); 
          }
         
        }
     
    


