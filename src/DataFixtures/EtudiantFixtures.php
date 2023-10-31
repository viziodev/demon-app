<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EtudiantFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;
    public function  __construct(UserPasswordHasherInterface $encoder){
        $this->encoder=$encoder;
  }
    public function load(ObjectManager $manager)
    {
         $plainPassword = 'passer@123';
            for ($i = 1; $i <=10; $i++) {
                $user = new Etudiant();
                $user->setNomComplet('Nom et Prenom  '.$i);
                $user->setEmail('etudiant'.$i."@gmail.com");
                $user->setMatricule("MAT0000".$i);
                $user->setTuteur("Tuteur ".$i);
                $user->setRoles(["ROLE_ETUDIANT"]);
                $encoded = $this->encoder->hashPassword($user,
                $plainPassword);
                $user->setPassword($encoded);
                $this->addReference("Etudiant".$i, $user);
                $manager->persist($user);
       }
              $manager->flush();
      
}
}