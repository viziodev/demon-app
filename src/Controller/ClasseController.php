<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\DataFixtures\NiveauFixtures;
use App\Repository\ClasseRepository;
use App\Repository\NiveauRepository;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isNull;

class ClasseController extends AbstractController{
    private const LIMIT=3;
    #[Route('/classe', name: 'app_classe',methods:["GET"])]
    public function index(Request $request,NiveauRepository $niveauRepository,FiliereRepository $filiereRepository,ClasseRepository $classeRepository): Response
    {
        //Recuperation du Parametre Get et Initiamisation à 1
         $page=(int)$request->query->get("page",1) ; 
         $count= $classeRepository->countClasse();
         $classes=$classeRepository->findPaginate($page,self::LIMIT);
         $nbrePage= ceil($count/self::LIMIT);
        
         return $this->render('classe/index.html.twig', [
            'niveaux' => $niveauRepository->findBy(["isActive"=>true]),
            'filieres' => $filiereRepository->findBy(["isActive"=>true]),
            'classes' =>  $classes,
            'nbre_page' =>  $nbrePage,
            'page' => $page,
         ]);
    }

    #[Route('/classe/filtre', name: 'app_classe_filtre',methods:["POST","GET"])]
    public function filtre(Request $request,NiveauRepository $niveauRepository,FiliereRepository $filiereRepository,ClasseRepository $classeRepository): Response
    {
        //Recuperation du Parametre Get et Initiamisation à 1
        
          if($request->request->has("btn_save")){
               $filiere=$request->request->get("filiere");
               $niveau=$request->request->get("niveau");
                $selected=[];
                if(!empty($filiere)) $selected["filiere"] =$filiere;
                if(!empty($niveau))  $selected["niveau"] =$niveau;
                if(count($selected)==0){
                    return $this->redirectToRoute("app_classe");
                }
                $filtres=[
                    "filiere" =>$filiere,
                    "niveau" =>$niveau
                 ];
                $page=(int)$request->query->get("page",1) ; 
                $classes=$classeRepository->findPaginateByFiltre($page,self::LIMIT, $filtres);
                $count= count($classes);
                $nbrePage= ceil($count/self::LIMIT);
                $filtres["isActive"]=true;
                return $this->render('classe/index.html.twig', [
                     'niveaux' =>  $niveauRepository->findBy(["isActive"=>true]),
                     'filieres' => $filiereRepository->findBy(["isActive"=>true]),
                     'classes' =>   $classes,
                     "selected"=> $selected,
                     'nbre_page' =>  $nbrePage,
                     'page' => $page,
                ]);   
        
           }
       
           return $this->redirectToRoute("app_classe");
    }


    #[Route('/classe/save/{id?}', name: 'app_classe_save',methods:["GET","POST"])]
    public function store($id,Request $request,EntityManagerInterface $manager,ClasseRepository $classeRepository): Response
    {
      if($id==null){
        $data = new Classe();
      }else{
        $data=$classeRepository->find($id);
      }
      
        //Creation du Formulaire
        $form =$this->createForm(ClasseType::class, $data);
        //Clique du Button Submit
          $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
              $manager->persist($data);
              $manager->flush();
              $this->addFlash("message","Classe cree");
           }
            return $this->render('classe/form.html.twig', [
                'form' => $form->createView(),
            ]);
    }
   

    #[Route('/classe/remove/{id}', name: 'app_classe_remove',methods:["POST"])]
    public function remove(): Response
    {
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
        ]);
    }
}

   

