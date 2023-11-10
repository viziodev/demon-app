<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Repository\ModuleRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfesseurController extends AbstractController
{
    private const LIMIT=2;
    #[Route('/professeur', name: 'app_professeur',methods:["GET"])]
    public function index(Request $request,ProfesseurRepository $professeurRepository,ModuleRepository $moduleRepository,PaginatorInterface $paginator): Response
    {
        $paginator=  $paginator->paginate(
            $professeurRepository->findBy(["isActive"=>true]), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            self::LIMIT // Nombre de résultats par page
        );
        //dd($paginator);
        return $this->render('professeur/index.html.twig', [
            'modules' => $moduleRepository->findBy(["isActive"=>true]),
            'datas' => $paginator,
         ]);
    }

    #[Route('/professeur/save/{id?}', name: 'app_professeur_save',methods:["GET","POST"])]
    public function store($id,Request $request,EntityManagerInterface $manager,ProfesseurRepository $professeurRepository): Response
    {
      if($id==null){
        $data = new Professeur();
      }else{
        $data=$professeurRepository->find($id);
      }
      
        //Creation du Formulaire
        $form =$this->createForm(ProfesseurType::class, $data);
        //Clique du Button Submit
          $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
              $manager->persist($data);
              $manager->flush();
              $this->addFlash("message","Professeur cree");
           }
            return $this->render('professeur/form.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}
