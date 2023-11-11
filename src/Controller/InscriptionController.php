<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use App\Repository\AnneeScolaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    private UserPasswordHasherInterface $encoder;
      public function  __construct(UserPasswordHasherInterface $encoder){
        $this->encoder=$encoder;
      }
    #[Route('/inscription/show', name: 'inscription_show')]
    public function index(InscriptionRepository $repoIns,AnneeScolaireRepository $repoAnn, ClasseRepository $repoClasse,SessionInterface $session): Response
    {
      
        $anneeEncours=$session->get('anneeEncours');
        $inscrits = $repoIns->findBy([
            'anneeScolaire'=>$anneeEncours,
             "isActive"=>true
        ]);
        $classes = $repoClasse->findAll();
          return $this->render('inscription/index.html.twig', [
           'inscrits' => $inscrits ,
            "classes"=>$classes,
         ]);

    }

    #[Route('/inscription/save/{id?}', name: 'app_inscription_save',methods:["GET","POST"])]
    public function store($id,Request $request,EntityManagerInterface $manager,InscriptionRepository $inscriptionRepository,SessionInterface $session,AnneeScolaireRepository $anneeScolaireRepository): Response
    {
      if($id==null){
        $data = new Inscription();
        $data->setEtudiant(new Etudiant());
        $data->getEtudiant()->setRoles(["ROLE_ETUDIANT"]);
        $data->getEtudiant()->setMatricule(uniqid());
      }else{
         $data=$inscriptionRepository->find($id);
         $data->getEtudiant()->setPassword("");
      }
    
        //Creation du Formulaire
        $form =$this->createForm(InscriptionType::class, $data);
        //Clique du Button Submit
          $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $this->encoder->hashPassword( $data->getEtudiant(), $data->getEtudiant()->getPassword());
                            $data->getEtudiant()->setPassword($encoded);
            $anneeEncours = $anneeScolaireRepository->find($session->get("anneeEncours")->getId());
            $data->setAnneeScolaire($anneeEncours);
               $manager->persist($data);
               $manager->flush();
             //  $this->addFlash("message","Etudiant cree");

           }
            return $this->render('inscription/form.html.twig', [
                'form' => $form->createView(),
            ]);
    }

    
}
