<?php

namespace App\Controller;

use App\Repository\AnneeScolaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnneeScolaireController extends AbstractController
{
    #[Route('RP/annee/change', name: 'annee_scolaire_change')] 
    public function changeAnneeEncours(Request $request,AnneeScolaireRepository $repo, SessionInterface $session): Response{
       // dd($request->isXmlHttpRequest());
          if($request->isXmlHttpRequest() || $request->query->get('id')!=0 ) {
            $id =(int) $request->query->get('id'); 
             $anneesInSession= $session->get("annees"); 
           //  dd(  $anneesInSession);
             $anneeEncours = $repo->find($id );
             $session->set('anneeEncours', $anneeEncours);
             $anneesInSession= $session->set("annees",  $this->changeAnneeInSession($anneesInSession, $id )); 
            
          }
         // return $this->redirectToRoute("inscription_show");
            return new JsonResponse($this->generateUrl('inscription_show'));
    }

    private function changeAnneeInSession(array $anneesInSession,int $id):array{ 
        foreach ($anneesInSession as $key=> $annee) {
        if($annee->getId()==$id){
            $anneesInSession[$key]->setIsActive(true);
        }else{
            $anneesInSession[$key]->setIsActive(false);
       } 
       return $anneesInSession;
 
    }
}
        
    
}
