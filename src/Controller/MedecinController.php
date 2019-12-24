<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedecinController extends AbstractController
{

    //affichage de l'ensemble des medecins

    /**
     * @Route("/medecin/show", name="medecin.medecin.show")
     */
   
    public function showMedecin(MedecinRepository $repos)
    {
        $medecins = $repos->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecins'=>$medecins
            
        ]);
    }

    //fin affichage de l'ensemble des medecins
//formulaire d'ajout de medecin
   /**
    * @Route("/medecin/add", name="medecin.medecin.add")
     */
    public function addMedecin( Request $request)
    {
    
        $idMatricule = $this->getLastMedecin() +1;
    
        $medecin = new Medecin();

    $form = $this->createForm(MedecinType::class, $medecin);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

        $twoFirstLetter =\strtoupper(\substr($medecin->getService()->getLibelle(),0,2));
        $longId = strlen((string)$idMatricule);
        $matricule = \str_pad("M".$twoFirstLetter,8 - $longId, "0").$idMatricule;
        $medecin->setMatricule($matricule);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($medecin);
        $entityManager->flush();
        $this->addFlash('success', 'Medecin crée avec succés');

       return $this->redirectToRoute('medecin.medecin.show');
   
   }
   return $this->render('medecin/form.html.twig', [
       'form' => $form->createView(),
   ]);


}

//debut modification
   /**
    * @Route("/medecin/edit{id}", name="medecin.medecin.edit")
     */
    
    public function editMedecin($id, Request $request,MedecinRepository $repos )
    {
    
    
    $medecin=$repos->find($id);

    $form = $this->createForm(MedecinType::class, $medecin);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($medecin);
        $entityManager->flush();

       return $this->redirectToRoute('medecin.medecin.show');
   
   }
   return $this->render('medecin/form.html.twig', [
       'form' => $form->createView(),
   ]);


}

//suppression d'un medecin

   /**
    * @Route("/medecin/delete{id}", name="medecin.medecin.delete")
     */
    
    public function deleteMedecin($id, MedecinRepository $repos )
    {
    
    
    $medecin=$repos->find($id);
    $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($medecin);
         $entityManager->flush();

        return $this->redirectToRoute('medecin.medecin.show');
    
    }



    public function getLastMedecin()
    {
        $ripo = $this->getDoctrine()->getRepository(Medecin::class);
        $medecinLast = $ripo->findBy([],['id'=>'DESC']);
        if($medecinLast == null)
        {
            return $id = 0;
        }
        else
        {
            return $medecinLast[0]->getId();
        }
    }








    
}
