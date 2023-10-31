<?php

namespace App\DataFixtures;

use App\Entity\Professeur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfesseurFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    public function  __construct(UserPasswordHasherInterface $encoder){
          $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $grade=["MASTER","INGENIEUR","DOCTEUR"];
         $plainPassword = 'passer@123';
            for ($i = 1; $i <=count($grade); $i++) {
                  $user = new Professeur();
                  $pos=rand(1,10);
                  $user->setNomComplet('Nom et Prenom  '.$i);
                  $user->setEmail('professeur'.$i."@gmail.com");
                $encoded = $this->encoder->hashPassword($user,
$plainPassword);
                $user->setPassword($encoded);
                $user->setRoles(["ROLE_PROFESSEUR"]);
                $user->setGrade($grade[$i-1]);
                 for ($j = 1; $j<=$pos; $j++) {
                   $user->addModule($this->getReference("Module".$j));
                 }
                 $this->addReference("Professeur".$i, $user);
                 $manager->persist($user);
              }
              $manager->flush();

}

public function getDependencies()
{
    return array(
        ModuleFixtures::class,
); 
}
}
